<?php

namespace App\Http\Resources\Api\V1\Agent;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuotationItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'product' => new \App\Http\Resources\Api\V1\Admin\ProductResource($this->product),
            'quantity' => $this->quantity,
            'price' => $this->price,
        ];
    }
}
