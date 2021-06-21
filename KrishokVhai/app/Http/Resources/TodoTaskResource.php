<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TodoTaskResource extends JsonResource
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
            'todo_id' => $this->todo_id,
            'title' => $this->title,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'deleted_at' => $this->deleted_at,
            'todo' => TodoResource::collection($this->whenLoaded("todo")),
        ];
    }
}
