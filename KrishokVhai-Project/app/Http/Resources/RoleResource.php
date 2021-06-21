<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
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
        // Using this resource in Role API Controller
        return [
            'id' => $this->id,
            'name' => $this->name,
            'permissions_count' => count($this->permissions)
        ];
    }
}
