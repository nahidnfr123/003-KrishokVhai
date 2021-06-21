<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserWithProductsResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'username' => $this->username,
            'gender' => $this->gender,
            'dob' => $this->dob,
            'mobile_number' => $this->mobile_number,
            'status' => $this->status,
            'avatar' => $this->avatar,
            'verified_at' => $this->verified_at,
            'created_at' => $this->created_at,
            'deleted_at' => $this->deleted_at,

            //'address' => $this->address ? AddressResource::collection(collect()->push($this->address)) : null,
            'address' => $this->address ? AddressResource::collection($this->address) : null,
            'products' => $this->products ? ProductResource::collection($this->products) : null,
            'farmer' => $this->farmer,
            'retailer' => $this->retailer,
            'officer' => $this->officer,

            'roles' => $this->getRoleNames(),
        ];
    }
}
