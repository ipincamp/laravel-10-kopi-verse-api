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
            'total_products' => $this->items->count(),
            'total_price' => $this->items->sum(function ($item) {
                return $item->product->price * $item->quantity;
            }),
            'products' => CartItemResource::collection($this->items),
        ];
    }
}
