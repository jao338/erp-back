<?php

namespace ERP\Models\Supplier\Actions;

use ERP\Exceptions\ERPException;
use ERP\Models\Supplier\Supplier;

final readonly class ShowAction {

    public function __construct(protected Supplier $model) {}

    public function handle(string $uuid): ?Supplier
    {
        $supplier = $this->model
            ->where('uuid', $uuid)
            ->first();

        throw_if(
            !$supplier,
            new ERPException(__('messages.not_found'), 404),
        );

        return $supplier;
    }
}
