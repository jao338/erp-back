<?php

namespace ERP\Models\Sale;

use ERP\Models\Client\Client;
use ERP\Models\SaleItem\SaleItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Sale extends Model {

    protected $table        = 'sale';
    protected $primaryKey   = 'id';
    protected $keyType      = 'int';
    public $incrementing    = true;
    public $timestamps      = true;

    protected $casts  = [
        'ativo' => 'boolean',
    ];

    protected $fillable = [
        'uuid',
        'client_id',
        'total',
        'profit',
        'active',
    ];

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function saleItems(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }


    protected static function booted(): void
    {
        static::creating(function (self $sale) {
            if (empty($sale->uuid)) {
                $sale->uuid = (string) Str::uuid();
            }
        });
    }
}
