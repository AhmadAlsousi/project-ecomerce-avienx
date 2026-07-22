<?php

namespace App\Models;

use App\Enum\Users\UserStatusEnum as UserUserStatusEnum;
use App\Enum\Users\UserTypeEnum;
use App\Enums\Users\UserStatusEnum;
// use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Spatie\Permission\Traits\HasRoles;
class User extends Authenticatable implements JWTSubject
{
    use HasRoles;
    use HasFactory;
 
    use Notifiable;
    use SoftDeletes;
// protected string $guard_name = 'api';
protected $guard_name = 'api';
    protected $fillable = [
        'id',
        'name',
        'email',
        'phone',
        'password',
        'type',
        'status',
        'email_verified_at',
        'phone_verified_at',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'type' => UserTypeEnum::class,
            'status' => UserUserStatusEnum::class,
            'email_verified_at' => 'datetime',
            'phone_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
        ];
    }

    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class);
    }

    public function admin(): HasOne
    {
        return $this->hasOne(Admin::class);
    }

    public function vendor(): HasOne
    {
        return $this->hasOne(Vendor::class);
    }
        public function products()
    {
        return $this->belongsTo(Products::class);
    }
 public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }
    // public function roles(): BelongsToMany
    // {
    //     return $this->belongsToMany(Role::class)->withTimestamps();
    // }

    // public function addresses(): HasMany
    // {
    //     return $this->hasMany(Address::class);
    // }

    // public function carts(): HasMany
    // {
    //     return $this->hasMany(Cart::class);
    // }

    // public function orders(): HasMany
    // {
    //     return $this->hasMany(Order::class);
    // }

    // public function reviews(): HasMany
    // {
    //     return $this->hasMany(Review::class);
    // }

    // public function paymentMethods(): HasMany
    // {
    //     return $this->hasMany(PaymentMethod::class);
    // }

    // public function notificationChannels(): HasMany
    // {
    //     return $this->hasMany(NotificationChannel::class);
    // }

    // public function customNotifications(): HasMany
    // {
    //     return $this->hasMany(Notification::class);
    // }

    // public function hasRole(string $role): bool
    // {
    //     return $this->roles()->where('name', $role)->exists();
    // }

    // public function hasPermission(string $permission): bool
    // {
    //     return $this->roles()
    //         ->whereHas('permissions', fn ($query) => $query->where('name', $permission))
    //         ->exists();
    // }
}