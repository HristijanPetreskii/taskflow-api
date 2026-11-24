<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;

class TaskController extends Controller
{
   public function index(Request $request)
   {
    $query = $request->user()->tasks();

    if ($request->has('completed')) {
        $query->where('completed', $request->completed);
    }

    if ($request->has('search')) {
    $query->where('title', 'LIKE', '%' . $request->search . '%');
    }

    $tasks = $query->paginate(10);

    return TaskResource::collection($tasks);
    }

    public function store(StoreTaskRequest $request)
    {
    $data = $request->validated();
    $data['completed'] = $data['completed'] ?? false;
    $task = $request->user()->tasks()->create($data);
    return (new TaskResource($task))->response()->setStatusCode(201); 
    }

    public function show(Request $request, Task $task)
    {
    $task = $request->user()->tasks()->findOrFail($task->id);

    return new TaskResource($task);
    }

 
    public function update(UpdateTaskRequest $request, Task $task)
    {
    $task = $request->user()->tasks()->findOrFail($task->id);

    $task->update($request->validated());

    return new TaskResource($task);
    }

   public function destroy(Request $request, Task $task)
   {
    $task = $request->user()->tasks()->findOrFail($task->id);

    $task->delete();

    return response()->json([
        'message' => 'Task deleted successfully',
    ]);
    }
}