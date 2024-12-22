<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'barcode' => $this->barcode,
            'date' => $this->created_at->format('d/m/Y H:i'),
            'total' => $this->items->sum('sub_total'),
            'status' => $this->status,
            'notes' => $this->notes,
            'items' => OrderItemResource::collection($this->items),
        ];
    }
}
