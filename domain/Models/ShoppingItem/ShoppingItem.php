<?php

namespace ERP\Models\ShoppingItem;

use ERP\Models\Product\Product;
use ERP\Models\Shopping\Shopping;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class ShoppingItem extends Model {

    protected $table        = 'shopping_item';
    protected $primaryKey   = 'id';
    protected $keyType      = 'int';

    public $incrementing    = true;
    public $timestamps      = true;


    protected $casts = [
        'unit_price' => 'float',
        'subtotal'   => 'float',
    ];

    protected $fillable = [
        'uuid',
        'shopping_id',
        'product_id',
        'unit_price',
        'amount',
        'subtotal'
    ];

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function shopping(): BelongsTo
    {
        return $this->belongsTo(Shopping::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    protected static function booted(): void
    {
        static::creating(function (self $shoppingItem) {
            if (empty($shoppingItem->uuid)) {
                $shoppingItem->uuid = (string) Str::uuid();
            }
        });
    }
}
