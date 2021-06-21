<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TodoCollection;
use App\Http\Resources\TodoResource;
use App\Http\Resources\TodoTaskResource;
use App\Models\Todo;
use App\Models\TodoTask;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodosController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param int $days
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($days = 7): \Illuminate\Http\JsonResponse
    {
        /*$todos = Todo::with('todoTasks')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'DESC')
            ->get()
            ->groupBy(function ($data) {
                return Carbon::parse($data->created_at)->format('m-d-Y');
                //return Carbon::parse($data->created_at)->format('m-d-Y H:i:s');
            });*/
        //$todos = Todo::getAllTodos();
        $date = Carbon::today()->subDays($days);

        $todos = Todo::where('user_id', Auth::id())
            //->where('created_at', '>=', $date)
            ->with('todoTasks')
            ->orderBy('todo_date', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->get();
        return (new TodoCollection($todos))->response();
        //return $todos;
        //return TodoResource::collection($todos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'title' => ['required', 'string', 'min:3', 'max:100'],
            'description' => 'sometimes',
            'tasks' => 'sometimes|array|min:1|max:5',
            /*'tasks.*.title' => 'required',*/
        ]);

        $todo = new Todo();
        $todo->user_id = Auth::id();
        $todo->title = ucfirst($request->title);
        $todo->assigned_to = 7;
        $request->forToday == false ? $todo->todo_date = Carbon::now()->addDay() : $todo->todo_date = Carbon::now();
        $todo->description = ucfirst($request->description);
        $todo->save();

        $tasks = $request->tasks;
        if ($tasks) {
            foreach ($tasks as $key => $task) {
                if ($task['title'] != '') {
                    $t = new TodoTask();
                    $t->todo_id = $todo->id;
                    $t->title = ucfirst($task['title']);
                    $t->save();
                }
            }
        }
        return (new TodoResource($todo))->response();
    }

    public function addTask(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'taskTitle' => ['required', 'string', 'min:3', 'max:100'],
            'todoId' => ['required', 'numeric'],
        ]);
        $todo = Todo::where('id', $request->todoId)->first();
        if ($todo) {
            $task = new TodoTask();
            $task->todo_id = $todo->id;
            $task->title = ucfirst($request->taskTitle);
            $task->save();
        } else {
            return response()->json(['error' => ['taskTitle' => "Cannot find todo list by  id = '" . $request->todoId . "'!"], 'status' => 500], 500);
        }
        return (new TodoResource($this->updateTodoStatus($request->todoId)))->response();
    }

    public function updateTask(Request $request, $taskId): \Illuminate\Http\JsonResponse
    {
        $task = TodoTask::where('id', $taskId)->first();
        $todoId = $task->todo_id; // Need to initiate todo id because it might change  .....
        if ($task) {
            if ($request->has('taskTitle')) {
                $task->title = ucfirst($request->taskTitle);
            }
            if ($request->has('todo_id') && $request['todo_id'] != "") {
                $task->todo_id = $request->todo_id;
            }
            if ($request->has('status')) {
                $task->status = $request->status;
            }
            $task->save();
        } else {
            return response()->json(['error' => ['task' => "Cannot find task by  id = '" . $taskId . "'!"], 'status' => 500], 500);
        }
        return (new TodoResource($this->updateTodoStatus($todoId)))->response();
    }

    public function updateTodoStatus($todoId)
    {
        $todo = Todo::find($todoId);
        if ($todo) {
            $i = 0;
            $tasks = $todo->todoTasks;
            if (count($tasks) > 0) {
                foreach ($todo->todoTasks as $tt) {
                    if ($tt->status != 'completed') {
                        ++$i;
                    }
                }
                if ($i == 0) {
                    $todo->status = 1;
                } else {
                    $todo->status = 0;
                }
                $todo->save();
            }
        }
        return $todo;
    }

    public function moveTodo(Request $request, $todoId): \Illuminate\Http\JsonResponse
    {
        $todo = Todo::findOrFail($todoId);
        $date = $request->dayOption;
        $todo->todo_date = Carbon::parse($date);
        if ($todo->save()) {
            return (new TodoResource($todo))->response();
        }
        return response()->json(['error' => "Failed to move todo!"], 500);
    }

    public function deleteTask($taskId): \Illuminate\Http\JsonResponse
    {
        $task = TodoTask::find($taskId);
        if (!$task->forceDelete()) {
            return response()->json(['error' => "Failed to delete task!"], 500);
        }
        return (new TodoTaskResource($task))->response();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return TodoResource
     */
    public function show(int $id): TodoResource
    {
        $todo = Todo::with('todoTasks')->findOrFail($id);
        return new TodoResource($todo);
    }

    public function getTodaysTodo(int $id): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        //$todo = Todo::where('user_id', Auth::id())->whereRaw("DATE(created_at) = '" . date('Y-m-d') . "'")->with('todoItems')->get();
        //$todo = Todo::where('user_id', Auth::id())->whereDate("created_at", date('Y-m-d'))->with('todoItems')->get();
        $todo = Todo::where('user_id', Auth::id())->whereDate("created_at", today())->with('todoTasks')->get();
        return TodoResource::collection($todo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $todo = Todo::with('todoTasks')->findOrFail($id);
        if ($todo) {
            $todo->title = ucfirst($request->title);
            if ($request->has('description') && $request["description"] != "") {
                $todo->description = ucfirst($request->description);
            }
            $todo->save();
        } else {
            return response()->json(['error' => ['task' => "Cannot find task by  id = '" . $id . "'!"], 'status' => 500], 500);
        }
        return (new TodoResource($todo))->response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Todo $todo
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Todo $todo): \Illuminate\Http\JsonResponse
    {
        if (!$todo->forceDelete()) {
            return response()->json(['error' => "Failed to delete todo!"], 500);
        }
        return (new TodoResource($todo))->response();
    }
}
