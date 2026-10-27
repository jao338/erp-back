<?php

namespace ERP\Models\Supplier;

use ERP\Models\Shopping\Shopping;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Supplier extends Model {

    use HasFactory;

    protected $table        = 'supplier';
    protected $primaryKey   = 'id';
    protected $keyType      = 'int';
    public $incrementing    = true;
    public $timestamps      = true;

    protected $casts  = [];

    protected $fillable = [
        'uuid',
        'name',
        'cnpj',
        'email',
        'telephone',
    ];

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function shopping(): HasMany
    {
        return $this->hasMany(Shopping::class);
    }

    protected static function newFactory()
    {
        return SupplierFactory::new();
    }

    protected static function booted(): void
    {
        static::creating(function (self $supplier) {
            if (empty($supplier->uuid)) {
                $supplier->uuid = (string) Str::uuid();
            }
        });
    }
}
