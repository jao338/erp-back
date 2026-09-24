<?php

namespace Base\Models\OTPCodes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class OTPCodes {

    protected $table       = 'otp_codes';
    protected $primaryKey  = 'id';
    protected $keyType     = 'int';

    public $incrementing   = true;
    public $timestamps     = true;

    protected $casts = [
        'id'         => 'integer',
        'expires_at' => 'datetime',
        'used_at'    => 'datetime'
    ];

    protected $fillable = [
        'user_id',
        'code',
        'type',
        'used_at',
        'expires_at',
        'attempts',
    ];

    public function scopeWhereIsFirstAccess($query): Builder
    {
        return $query->where('type', 1);
    }

}
