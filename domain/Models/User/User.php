<?php

namespace Base\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable {

    use HasApiTokens, HasFactory;

    protected $table       = 'user';
    protected $primaryKey  = 'id';
    protected $keyType     = 'int';

    public $incrementing   = true;
    public $timestamps     = true;

    protected $casts  = [];

    protected $fillable = [
        'uuid',
        'name',
        'email',
        'password',
        'verify_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function setActiveToken(string $token): void
    {
        $this->activeToken = $token;
    }

    public function getActiveToken(): string|null
    {
        return $this->activeToken ?? null;
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    protected static function newFactory()
    {
        return UserFactory::new();
    }

    protected static function booted(): void
    {
        static::creating(function (self $user) {
            if (empty($user->uuid)) {
                $user->uuid = (string) Str::uuid();
            }
            $user->password     = bcrypt($user->password);
        });
    }
}
