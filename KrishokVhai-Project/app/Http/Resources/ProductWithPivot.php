<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductWithPivot extends JsonResource
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

        $itemsUrl = [];
        if ($this->getMedia('products') && count($this->getMedia('products'))) {
            $mediaItems = $this->getMedia('products');
            foreach ($mediaItems as $key => $item) {
                $itemsUrl[] .= $item->getFullUrl();
            }
        }

        return [
            'id' => $this->id,
            'product_name' => $this->product_name,
            'product_slug' => $this->product_slug,
            'seller_id' => $this->seller_id,
            'seller' => $this->seller,
            'brand_id' => $this->brand_id,
            'status' => $this->status,
            'total_stock' => $this->total_stock,
            'stock_type' => $this->stock_type,
            'regular_price' => $this->regular_price,
            'retail_price' => $this->retail_price,
            'minimum_order_amount' => $this->minimum_order_amount,
            'currency' => $this->currency,
            'seen' => $this->pivot->seen ?: 0,
            'quantity' => $this->pivot->quantity && $this->pivot->quantity > 0 ? $this->pivot->quantity : null,
            'individual_order_status' => $this->pivot->individual_order_status ? $this->pivot->individual_order_status : null,
            'buying_price' => $this->pivot->buying_price ? $this->pivot->buying_price : null,
            'description' => html_entity_decode($this->description),
            'categories' => count($this->productCategory) > 0 ? ProductCategoryResource::collection($this->productCategory) : null,
            'first_image' => $this->getFirstMediaUrl('products'),
            //'images_thumb' => MediaResource::collection($this->getMedia('products')),
            'imageUrls' => count($itemsUrl) > 0 ? $itemsUrl : null,
            'created_at' => $this->created_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
