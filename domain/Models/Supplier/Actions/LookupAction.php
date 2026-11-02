<?php

namespace ERP\Models\Supplier\Actions;

use ERP\Models\Supplier\Supplier;
use Illuminate\Support\Collection;

final readonly class LookupAction {

    public function __construct(protected Supplier $model) {}

    public function handle(): Collection
    {
        return $this->model->join('person', 'person.id', '=', 'supplier.person_id')->select('supplier.uuid as value', 'person.name as label')->get();
    }
}
