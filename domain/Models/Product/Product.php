<?php

namespace ERP\Models\Product;

use ERP\Models\SaleItem\SaleItem;
use ERP\Models\ShoppingItem\ShoppingItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Product extends Model {

    use HasFactory;

    protected $table       = 'product';
    protected $primaryKey  = 'id';
    protected $keyType     = 'int';

    public $incrementing   = true;
    public $timestamps     = true;

    protected $casts  = [];

    protected $fillable = [
        'uuid',
        'name',
        'average_cost',
        'sale_price',
        'amount',
    ];

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function shoppingItems(): HasMany
    {
        return $this->hasMany(ShoppingItem::class);
    }

    public function saleItems(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }

    protected static function newFactory()
    {
        return ProductFactory::new();
    }

    protected static function booted(): void
    {
        static::creating(function (self $product) {
            if (empty($product->uuid)) {
                $product->uuid = (string) Str::uuid();
            }
        });
    }
}
