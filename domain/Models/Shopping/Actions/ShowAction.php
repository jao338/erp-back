<?php

namespace ERP\Models\Shopping\Actions;

use ERP\Exceptions\ERPException;
use ERP\Models\Shopping\Shopping;

final readonly class ShowAction {

    public function __construct(protected Shopping $model) {}

    public function handle(string $uuid): ?Shopping
    {
        $shopping = $this->model
            ->with(['shoppingItems', 'supplier'])
            ->where('uuid', $uuid)
            ->first();

        throw_if(
            !$shopping,
            new ERPException(__('messages.not_found'), 404),
        );

        return $shopping;
    }
}
