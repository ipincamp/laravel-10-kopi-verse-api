<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'item_id' => $this->id,
            'item_quantity' => $this->quantity,
            'product_id' => $this->product_id,
            'product_name' => $this->product->name,
            'product_category' => $this->product->category,
            'product_image' => $this->product->image,
            'product_price' => $this->product->price,
        ];
    }
}
