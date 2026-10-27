<?php

namespace ERP\Models\Shopping\Actions;

use ERP\Models\Product\Product;
use ERP\Models\Shopping\Shopping;
use Illuminate\Support\Facades\DB;

final readonly class CancelAction {

    public function __construct(protected Shopping $model) {}

    public function handle(string $uuid): void
    {
        DB::transaction(function () use ($uuid) {

            // Busca a compra pelo UUID com os itens
            $shopping = $this->model::where('uuid', $uuid)
                ->with('shoppingItems')
                ->firstOrFail();

            //  Percorre cada item da compra para reverter o estoque
            foreach ($shopping->shoppingItems as $item) {
                //  Busca o produto relacionado ao item e o trava no banco
                $product = Product::lockForUpdate()
                    ->findOrFail($item->product_id);

                //  Reverte a quantidade comprada
                $product->update([
                    'amount' => $product->amount - $item->amount,
                ]);
            }
            //  Remove os itens
            $shopping->shoppingItems()->delete();

            //  Remove a compra
            $shopping->delete();
        });
    }
}
