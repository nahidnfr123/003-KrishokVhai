<?php

namespace App\Http\Resources;

use App\Models\TodoItems;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TodoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $todoTasks = $this->whenLoaded('todoTasks');
        //return parent::toArray($request);

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'user_id' => $this->user_id,
            'date' => Carbon::parse($this->todo_date)->format('Y-m-d'),
            'todo_date' => $this->todo_date,
            'created_at' => $this->created_at,
            'deleted_at' => $this->deleted_at,
            //'todo_tasks' => TodoTaskResource::collection($todoTasks),
            'todo_tasks' => $this->todoTasks,
        ];
    }
}
