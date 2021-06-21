<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        // Adding all the product count from the sub categories to the Parent Category ...
        $proCounter = $this->products->count() ?: 0;
        if (count($this->children)) {
            foreach ($this->children as $child) {
                if ($child->products->count()) {
                    $proCounter += $child->products->count();
                }
            }
        }

        //return parent::toArray($request);
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'user_id' => $this->user_id,
            'parent_id' => $this->parent_id,
            'children' => count($this->children) > 0 ? self::collection($this->children) : null,
            'children_count' => count($this->children),
            'product_count' => $this->products ? $this->products->count() : null,
            'product_counter' => $proCounter,
        ];
    }
}
