<?php

namespace ERP\Models\OTPCodes;

use ERP\Enums\OtpType;
use ERP\Models\User\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OTPCodes extends Model {

    protected $table       = 'otp_codes';
    protected $primaryKey  = 'id';
    protected $keyType     = 'int';

    public $incrementing   = true;
    public $timestamps     = true;

    protected $casts = [
        'id'         => 'integer',
        'expires_at' => 'datetime: Y-m-d H:i',
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function scopeWhereIsFirstAccess($query): Builder
    {
        return $query->where('type', OtpType::FIRST_ACCESS);
    }

    public function scopeWhereIsNotUsed($query): Builder
    {
        return $query->where('used_at', NULL);
    }

}
