<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * A JaipurBnB user - either a property host or a site admin.
 *
 * role is a plain string column (no DB-level ENUM, for SQLite+MySQL
 * portability). Validate against self::ROLES in every FormRequest that
 * writes it. Note role is intentionally NOT in $fillable: it must never
 * be settable from request input, or a visitor could register as admin.
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    public const ROLE_HOST  = 'host';
    public const ROLE_ADMIN = 'admin';

    public const ROLES = [
        self::ROLE_HOST,
        self::ROLE_ADMIN,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isHost(): bool
    {
        return $this->role === self::ROLE_HOST;
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class, 'host_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'host_id');
    }
}
