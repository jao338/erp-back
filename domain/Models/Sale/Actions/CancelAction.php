<?php


namespace ERP\Models\Sale\Actions;

use ERP\Models\Product\Product;
use ERP\Models\Sale\Sale;
use Illuminate\Support\Facades\DB;
use RuntimeException;

final readonly class CancelAction
{
    public function __construct(protected Sale $model) {}
    public function handle(string $uuid): void
    {
        DB::transaction(function () use ($uuid) {

            // Busca a venda pelo UUID junto com seus itens
            $sale = $this->model::where('uuid', $uuid)
                ->with('saleItems')
                ->lockForUpdate()
                ->firstOrFail();

            // Impede cancelar uma venda já cancelada
            if (!$sale->active) {
                throw new RuntimeException('Venda já cancelada.');
            }

            // Para cada item da venda
            foreach ($sale->saleItems as $item) {

                // Busca o produto e trava edição simultânea
                $product = Product::lockForUpdate()
                    ->findOrFail($item->product_id);

                // Devolve o estoque
                $product->update([
                    'amount' => $product->amount + $item->amount,
                ]);
            }

            // Marca a venda como cancelada
            $sale->update([
                'active' => false,
                'total' => 0,
                'profit' => 0,
            ]);
        });
    }
}
