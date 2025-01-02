<?php

namespace App\Models\Api\V1\Agent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Models\Api\V1\Agent\Agent;

class Quotation extends Model
{
    use HasFactory;

    protected $fillable = [
        'agent_id',
        'total_price',
        'status', // e.g., 'draft', 'submitted', 'approved'
    ];

    public function agent()
    {
        return $this->belongsTo(Agent::class, 'agent_id');
    }

    public function items()
    {
        return $this->hasMany(QuotationItem::class, 'quotation_id');
    }
}
