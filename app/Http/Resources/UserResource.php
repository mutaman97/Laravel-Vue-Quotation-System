<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        logger($this->avatar);
        return [
            'id' => $this->id,
            'fullName' => $this->name,
            'username' => $this->username ?? 'guest', // Fallback if username is not present
            'email' => $this->email,
            'role' => $this->role ?? 'user', // Default role if not present
            'avatar' => $this->avatar ?? '/images/avatars/avatar-1.png', // Default avatar
        ];
    }
}
