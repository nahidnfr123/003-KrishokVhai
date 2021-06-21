<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TodoCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'message' => 'Todo',
            'code' => 200,
            'error' => false,
            'data' => $this->collection->transform(function ($todo) {
                //return $todo;
                return [
                    'id' => $todo->id,
                    'title' => $todo->title,
                    'description' => $todo->description,
                    'status' => $todo->status,
                    'user_id' => $todo->user_id,
                    'email_verified_at' => $todo->email_verified_at,
                    'date' => Carbon::parse($todo->todo_date)->format('Y-m-d'), // Use Y-m-d ... format .... for resolving firefox issue ...
                    'todo_date' => $todo->todo_date,
                    'created_at' => $todo->created_at,
                    'deleted_at' => $todo->deleted_at,
                    'todo_tasks' => $todo->todoTasks,
                ];
            })
        ];
    }
}
