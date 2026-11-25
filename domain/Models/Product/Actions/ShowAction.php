<?php

namespace ERP\Models\Product\Actions;

use ERP\Exceptions\ERPException;
use ERP\Models\Product\Product;

final readonly class ShowAction {

    public function __construct(protected Product $model) {}

    public function handle(string $uuid): ?Product
    {
        $product = $this->model
            ->where('uuid', $uuid)
            ->first();

        throw_if(
            !$product,
            new ERPException(__('messages.not_found'), 404),
        );

        return $product;
    }
}
