<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->product_id,
            'name' => $this->product->name,
            'category' => $this->product->category,
            'image' => $this->product->image,
            'price' => $this->product->price,
            'quantity' => $this->quantity,
        ];
    }
}
