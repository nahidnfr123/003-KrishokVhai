<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'username' => $this->username,
            'gender' => $this->gender,
            'dob' => $this->dob,
            'mobile_number' => $this->mobile_number,
            'status' => $this->status,
            'postal_code' => $this->postal_code,
            'avatar' => $this->avatar,
            'verified_at' => $this->verified_at,
            'created_at' => $this->created_at,
            'deleted_at' => $this->deleted_at,

            //'address' => $this->address ? AddressResource::collection(collect()->push($this->address)) : null,
            'address' => $this->address ? AddressResource::collection($this->address) : null,
            'farmer' => $this->farmer,
            'retailer' => $this->retailer,
            'officer' => $this->officer,
            'about' => $this->about,

            'roles' => $this->getRoleNames(),
        ];


    }
}
