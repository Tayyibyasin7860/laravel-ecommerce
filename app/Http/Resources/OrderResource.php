<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request)
    {

        $products_array = $this->products()
            ->get(["product_name","product_sku","product_description","product_price"])
            ->toArray() ?? [];
        return [
            'id' => $this->id,
            'order_number' => $this->order_number,
            'customer_name' => $this->customer->name,
            'status' => $this->status,
            'payment_status' => $this->payment_status,
            'products' => $products_array,
            'grand_total' => $this->grand_total,
            'created_at' => $this->created_at->format('d/m/Y'),
            'transactions' => $this->transactions->toArray() ?? [],
        ];
    }
}
