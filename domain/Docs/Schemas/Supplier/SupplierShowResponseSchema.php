<?php

namespace ERP\Docs\Schemas\Supplier;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'SupplierShowResponse',
    required: ['data']
)]
class SupplierShowResponseSchema
{
    #[OA\Property(ref: SupplierResponseSchema::class)]
    public SupplierResponseSchema $data;
}
