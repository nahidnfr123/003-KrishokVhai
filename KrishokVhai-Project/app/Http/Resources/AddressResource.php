<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);

        return [
            'user' => new UserResource($this->whenLoaded('user')),
            'id' => $this->id,
            'address' => $this->address,
            'country' => $this->country ? $this->country->only('name') : null,
            'state' => $this->state ? $this->state->only('name') : null,
            'city' => $this->city ? $this->city->only('name') : null,
        ];

    }
}
