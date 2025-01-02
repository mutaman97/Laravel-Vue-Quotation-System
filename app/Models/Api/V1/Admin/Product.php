<?php

namespace App\Models\Api\V1\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sku',
        'price',
        'stock',
        'category',
        'description'
    ];

    public function agentStocks()
    {
        return $this->hasMany(AgentStock::class, 'product_id');
    }
}
