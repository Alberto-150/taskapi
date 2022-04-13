<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Models\User;
use \App\Models\Task;

class TaskController extends Controller
{
    public function index()
    {
        return Task::all();
    }
    
    public function myTasks($id)
    {
        $tasks = is_null(User::find($id)) ? [] : User::find($id)->tasks;

        return response()->json([
            "response" => $tasks,
        ], 200);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validateStoreTask($request);

        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'done' => false,
            'user_id' => $request->user_id,
        ]);

        return response()->json([
            "status" => "success",
            "response" => "Tarea creada con exito"
        ], 200);
    }

    private function validateStoreTask(Request $request){
        $this->validate($request, [
            'title' => 'required|string|max:30',
            'description' => 'required|string',
            'user_id' => 'required|integer',
        ]);
    }

    public function show($id)
    {
        $task = Task::find($id);

        if (is_null($task)) {
            return response()->json([
                "status" => "error",
                "response" => "Recurso no encontrado"
            ], 404);
        }

        return response()->json([
            "status" => "success",
            "response" => $task,
        ], 200);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $this->validateUpdateTask($request);

        $task = Task::find($id);
        $task->title = $request->title;
        $task->description = $request->description;
        $task->done = $request->boolean('done');
        $task->save();

        return response()->json([
            "status" => "success",
            "response" => "Tarea actualizada con exito"
        ], 200);
    }

    private function validateUpdateTask(Request $request){
        $this->validate($request, [
            'title' => 'required|string|max:30',
            'description' => 'required|string',
            'done' => 'boolean',
        ]);
    }

    public function destroy($id)
    {
        $task = Task::find($id);

        if (is_null($task)) {
            return response()->json([
                "status" => "error",
                "response" => "Recurso no encontrado"
            ], 404);
        }
        
        $task->delete();

        return response()->json([
            "status" => "success",
            "response" => "Tarea eliminada con exito",
        ], 200);
    }
}
