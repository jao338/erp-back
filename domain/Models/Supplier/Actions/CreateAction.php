<?php

namespace ERP\Models\Supplier\Actions;

use ERP\Models\Supplier\SupplierDTO;
use ERP\Models\Supplier\Supplier;
use ERP\Models\Person\Person;
use Illuminate\Support\Facades\DB;

final readonly class CreateAction
{
    public function __construct(
        protected Supplier $model,
        protected Person $person
    ) {}

    public function handle(array $data): Supplier
    {
        $dto = SupplierDTO::fromArray($data);

        return DB::transaction(function () use ($dto): Supplier {
            $person = $this->person->create($dto->toPersonArray());

            return $this->model->create($dto->toSupplierArray($person->id))
                ->load('person');
        });
    }
}
