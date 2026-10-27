<?php

namespace ERP\Models\Sale\Actions;

use ERP\Models\Sale\Sale;

final readonly class ShowAction {

    public function __construct(protected Sale $model) {}

    public function handle(string $uuid): ?Sale
    {
        return $this->model
            ->with(['saleItems', 'client'])
            ->where('uuid', $uuid)
            ->firstOrFail();
    }
}
