<?php

namespace ERP\Models\Shopping\Actions;

use ERP\Models\Product\Product;
use ERP\Models\Shopping\Shopping;
use ERP\Models\ShoppingItem\ShoppingItem;
use ERP\Models\Supplier\Supplier;
use Illuminate\Support\Facades\DB;

final readonly class CreateAction
{

    public function handle(array $data): Shopping
    {
        return DB::transaction(function () use ($data) {

            $total = 0;

            //  Primeiro cria a compra
            $shopping = Shopping::create([
                'supplier_id' => Supplier::where('uuid', $data['fornecedor_uuid'])->first()->id,
                'total'       => 0,
            ]);

            //  Para cada item da compra
            foreach ($data['itens'] as $item) {

                //  Busca e trava para atualizações no mesmo produto
                $product = Product::lockForUpdate()->where('uuid', $item['produto_uuid'])->first();
                //  Calcula o subtotal, multiplicando a quantidade pelo preço unitário
                $subtotal = $item['quantidade'] * $item['preco_unitario'];

                //  Cria o item
                ShoppingItem::create([
                    'shopping_id' => $shopping->id,
                    'product_id'  => $product->id,
                    'unit_price'  => $item['preco_unitario'],
                    'amount'      => $item['quantidade'],
                    'subtotal'    => $subtotal,
                ]);

                //  Calcula a nova quantidade do produto recém-comprado
                $new_amount = $product->amount + $item['quantidade'];

                //  Média ponderada
                // ((valor antigo + valor novo) / quantidade total)
                $new_average_cost = (
                        ($product->average_cost * $product->amount) +
                        ($item['preco_unitario'] * $item['quantidade'])
                    ) / $new_amount;

                //  Atualiza a quantidade e o custo médio
                $product->update([
                    'amount'       => $new_amount,
                    'average_cost' => $new_average_cost,
                ]);

                //  Atualiza o valor total somando cada subtotal
                $total += $subtotal;
            }

            //  Atualiza a compra com o total
            $shopping->update(['total' => $total]);

            //  Retorna a compra
            return $shopping;
        });
    }
}
