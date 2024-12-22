<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'unique_id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'image' => $this->image,
            'role' => $this->getRoleNames()->first(),
            'join_since' => $this->created_at->diffForHumans(),
            'all_orders' => $this->orders->count(),
        ];
    }
}
