<?php

namespace ERP\Models\Supplier\Actions;

use ERP\Models\Supplier\SupplierDTO;
use ERP\Models\Supplier\Supplier;
use Illuminate\Support\Facades\DB;

final readonly class UpdateAction
{
    public function __construct(protected Supplier $model) {}

    public function handle(string $uuid, array $data): bool
    {
        $dto = SupplierDTO::fromArray($data);

        return DB::transaction(function () use ($uuid, $dto): bool {
            $supplier = $this->model->with('person')->where('uuid', $uuid)->firstOrFail();
            $supplier->person->update($dto->toPersonArray());

            return $supplier->update($dto->toSupplierArray($supplier->person_id));
        });
    }
}
