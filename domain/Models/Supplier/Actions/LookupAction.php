<?php

namespace ERP\Models\Supplier\Actions;

use ERP\Models\Supplier\Supplier;
use Illuminate\Support\Collection;

final readonly class LookupAction {

    public function __construct(protected Supplier $model) {}

    public function handle(): Collection
    {
        return $this->model->select('uuid as value', 'name as label')->get();
    }
}
