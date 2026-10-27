<?php

namespace ERP\Models\Shopping;

use ERP\Models\SaleItem\SaleItem;
use ERP\Models\ShoppingItem\ShoppingItem;
use ERP\Models\Supplier\Supplier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Shopping extends Model {

    protected $table        = 'shopping';
    protected $primaryKey   = 'id';
    protected $keyType      = 'int';
    public $incrementing    = true;
    public $timestamps      = true;

    protected $casts  = [];

    protected $fillable = [
        'uuid',
        'supplier_id',
        'total',
    ];

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function shoppingItems(): HasMany
    {
        return $this->hasMany(ShoppingItem::class);
    }

    protected static function booted(): void
    {
        static::creating(function (self $shopping) {
            if (empty($shopping->uuid)) {
                $shopping->uuid = (string) Str::uuid();
            }
        });
    }
}
