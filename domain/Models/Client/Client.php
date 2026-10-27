<?php

namespace ERP\Models\Client;

use ERP\Models\Sale\Sale;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Client extends Model {

    use HasFactory;

    protected $table        = 'client';
    protected $primaryKey   = 'id';
    protected $keyType      = 'int';
    public $incrementing    = true;
    public $timestamps      = true;

    protected $casts  = [];

    protected $fillable = [
        'uuid',
        'name',
        'cpf',
        'email',
        'telephone',
    ];

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function sale(): HasMany
    {
        return $this->hasMany(Sale::class);
    }

    protected static function newFactory()
    {
        return ClientFactory::new();
    }

    protected static function booted(): void
    {
        static::creating(function (self $client) {
            if (empty($client->uuid)) {
                $client->uuid = (string) Str::uuid();
            }
        });
    }
}
