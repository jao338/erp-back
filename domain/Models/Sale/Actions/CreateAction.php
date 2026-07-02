<?php

namespace Base\Models\Sale\Actions;

use Base\Base\Exceptions\ERPException;
use Base\Models\Client\Client;
use Base\Models\Product\Product;
use Base\Models\Sale\Sale;
use Base\Models\SaleItem\SaleItem;
use Illuminate\Support\Facades\DB;
final readonly class CreateAction
{
    public function handle(array $data): Sale
    {
        return DB::transaction(function () use ($data) {

            $total  = 0;
            $profit = 0;

            // Busca o cliente pelo UUID
            $client = Client::where('uuid', $data['cliente_uuid'])->firstOrFail();

            // Cria a venda (ainda sem totais)
            $sale = Sale::create([
                'client_id' => $client->id,
                'total'     => 0,
                'profit'    => 0,
                'active'    => true,
            ]);

            // Percorre os itens da venda
            foreach ($data['itens'] as $item) {

                // Trava o produto para evitar concorrência
                $product = Product::lockForUpdate()
                    ->where('uuid', $item['produto_uuid'])
                    ->firstOrFail();

                // Valida estoque disponível
                if ($product->amount < $item['quantidade']) {
                    throw ERPException::withMessages([
                        'estoque' => "Estoque insuficiente para o produto {$product->name}",
                    ]);
                }

                // Calcula valores do item
                $subtotal   = $item['quantidade'] * $item['preco_unitario'];
                $item_cost   = $product->average_cost * $item['quantidade'];
                $item_profit = $subtotal - $item_cost;

                // Cria o item da venda
                SaleItem::create([
                    'sale_id'    => $sale->id,
                    'product_id' => $product->id,
                    'amount'     => $item['quantidade'],
                    'unit_price' => $item['preco_unitario'],
                    'unit_cost'  => $product->average_cost,
                    'subtotal'   => $subtotal,
                    'profit'     => $item_profit,
                ]);

                // Baixa o estoque
                $product->update([
                    'amount' => $product->amount - $item['quantidade'],
                ]);

                // Acumula totais
                $total  += $subtotal;
                $profit += $item_profit;
            }

            // Atualiza totais da venda
            $sale->update([
                'total'  => $total,
                'profit' => $profit,
            ]);

            return $sale;
        });
    }
}
