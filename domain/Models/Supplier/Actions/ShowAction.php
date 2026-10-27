<?php

namespace ERP\Models\Supplier\Actions;

use ERP\Models\Supplier\Supplier;

final readonly class ShowAction {

    public function __construct(protected Supplier $model) {}

    public function handle(string $uuid): ?Supplier
    {
        return $this->model
            ->where('uuid', $uuid)
            ->firstOrFail();
    }
}
