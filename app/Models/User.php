<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Mindscms\Entrust\Traits\EntrustUserWithPermissionsTrait;
use Nicolaslopezj\Searchable\SearchableTrait;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory,SearchableTrait, Notifiable ,EntrustUserWithPermissionsTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        // 'name',
        // 'email',
        // 'password',

        'first_name',
        'last_name',
        'username',
        'email',
        'mobile',
        'password',
        'user_image',
        'status',
    ];

    protected $appends = ['full_name'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public $searchable = [
        'columns' => [
            'users.first_name'                              =>10,
            'users.last_name'                               =>10,
            'users.username'                                =>10,
            'users.email'                                   =>10,
            'users.mobile'                                  =>10,
        ]
        ];

    public function getFullNameAttribute(): string
    {
        return ucfirst($this->first_name) . '' . ucfirst($this->last_name);
    }

    public function status(): string
    {
        return $this->status ? 'Active': 'Inactive';
    }

    public function reviews() : HasMany
    {
        return $this->hasMany(ProductReview::class, 'mediable');
    }

    public function addresses() : HasMany
    {
        return $this->hasMany(UserAddress::class);
    }
}
