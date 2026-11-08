<?php

namespace ERP\Models\Sale\Actions;

use ERP\Exceptions\ERPException;
use ERP\Models\Sale\Sale;

final readonly class ShowAction {

    public function __construct(protected Sale $model) {}

    public function handle(string $uuid): ?Sale
    {
        $sale = $this->model
            ->with(['saleItems', 'client'])
            ->where('uuid', $uuid)
            ->first();

        throw_if(
            !$sale,
            new ERPException(__('messages.not_found'), 404),
        );

        return $sale;
    }
}
