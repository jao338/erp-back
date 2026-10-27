<?php

namespace ERP\Models\Product\Actions;

use ERP\Models\Product\Product;

final readonly class DestroyAction {

    public function __construct(protected Product $model) {}

    public function handle(string $uuid): bool
    {
        $product = $this->model->where('uuid', $uuid)->firstOrFail();

        return $product->delete();
    }
}
