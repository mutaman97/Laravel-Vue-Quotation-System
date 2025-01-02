<?php

namespace App\Models\Api\V1\Agent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Agent extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'company_name'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function quotations()
    {
        return $this->hasMany(Quotation::class);
    }

    public function stocks()
    {
        return $this->hasMany(\App\Models\Api\V1\Admin\AgentStock::class, 'agent_id');
    }
}
