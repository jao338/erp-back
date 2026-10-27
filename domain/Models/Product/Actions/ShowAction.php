<?php

namespace ERP\Models\Product\Actions;

use ERP\Models\Product\Product;

final readonly class ShowAction {

    public function __construct(protected Product $model) {}

    public function handle(string $uuid): ?Product
    {
        return $this->model
            ->where('uuid', $uuid)
            ->firstOrFail();
    }
}
