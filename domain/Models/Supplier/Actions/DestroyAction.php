<?php

namespace ERP\Models\Supplier\Actions;

use ERP\Models\Supplier\Supplier;

final readonly class DestroyAction
{
    public function __construct(protected Supplier $model) {}

    public function handle(string $uuid): bool
    {
        $supplier = $this->model->where('uuid', $uuid)->firstOrFail();

        return $supplier->delete();
    }
}
