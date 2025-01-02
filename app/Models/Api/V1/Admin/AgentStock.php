<?php

namespace App\Models\Api\V1\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'agent_id',
        'product_id',
        'quantity'
    ];

    public function agent()
    {
        return $this->belongsTo(\App\Models\Api\V1\Agent\Agent::class, 'agent_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
