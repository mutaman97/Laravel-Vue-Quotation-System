<?php

namespace App\Models\Api\V1\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'fullName',
        'username',
        'password',
        'avatar',
        'email',
        'role',
        'abilityRules',
    ];

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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'abilityRules' => 'array', // Cast the abilityRules field to an array
        ];
    }

    /**
     * Get the default avatar if none is provided.
     *
     * @return string
     */
    public function getAvatarAttribute($value)
    {
        return $value ?? url('/images/avatars/avatar-1.png');
    }

    /**
     * Admin can have many agents associated with it.
     */
    public function agents()
    {
        return $this->hasMany(\App\Models\Api\V1\Agent\Agent::class);
    }

    /**
     * Admin can create multiple products.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
