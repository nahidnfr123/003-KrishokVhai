<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class OrdersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'id' => $this->id,
            'customer_id' => $this->user_id,
            'customer' => $this->user,
            'order_no' => $this->order_no,
            //'address_id' => $this->address_id,
            'address' => $this->address ? new AddressResource($this->address) : null,
            //'address' => $this->address,
            'total_price' => $this->total_price,
            'payment_method' => $this->payment_method,
            'order_status' => $this->order_status,
            'payment_status' => $this->payment_status,
            'pinned' => $this->pinned,
            'products' => count($this->products) > 0 ? ProductWithPivot::collection($this->products) : null,
            'created_at' => $this->created_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
