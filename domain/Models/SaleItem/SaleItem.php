<?php

namespace ERP\Models\SaleItem;

use ERP\Models\Product\Product;
use ERP\Models\Sale\Sale;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class SaleItem extends Model {

    protected $table        = 'sale_item';
    protected $primaryKey   = 'id';
    protected $keyType      = 'int';
    public $incrementing    = true;
    public $timestamps      = true;

    protected $casts  = [
        'id'            => 'integer',
        'sale_id'       => 'integer',
        'product_id'    => 'integer',
        'amount'        => 'float',
        'unit_price'    => 'float',
        'unit_cost'     => 'float',
        'subtotal'      => 'float',
        'profit'        => 'float',
    ];

    protected $fillable = [
        'uuid',
        'sale_id',
        'product_id',
        'amount',
        'unit_price',
        'unit_cost',
        'subtotal',
        'profit'
    ];

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    protected static function booted(): void
    {
        static::creating(function (self $saleItem) {
            if (empty($saleItem->uuid)) {
                $saleItem->uuid = (string) Str::uuid();
            }
        });
    }
}
