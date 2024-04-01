<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{

    public function newTask(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'task' => 'required|string|max:255',
            'details' => 'required|string|max:3000',
        ]);

        $task = new Task();
        $task->user_id = $request->user_id;
        $task->task = $request->task;
        $task->details = $request->details;
        $task->save();

        return response($task, Response::HTTP_CREATED);
    }

    public function deleteTask(Request $request){
        $request->validate([
            'id' => 'required|integer',
        ]);

        $task = Task::find($request->id);

        if ($task) {        

            $task->delete();

            return response(['message' => 'Task deleted'], Response::HTTP_OK);
        }
        else {
            return response()->json(['message' => 'Task not found'], Response::HTTP_NOT_FOUND);
        }
    }

    public function changeEmployee(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|integer'
        ]);

        $task = Task::findOrFail($id);
        $user = User::findOrFail($request->user_id);

        // Asignar el nuevo usuario a la tarea
        $task->user_id = $request->user_id;
        $task->save();

        return response(['message' =>'Successful change'], Response::HTTP_OK);

    }

    public function changeStatus(Request $request){
        $request->validate([
            'id' => 'required|integer',
            'status' => ['required', 'string', 'max:255', Rule::in(['Pendiente', 'En proceso', 'Bloqueado', 'Completado'])],
        ]);

        $userId = Auth::id();
        $user= User::find($userId);
        $task = Task::find($request->id);

        if($task && ($task->user_id == $userId || $user->isSuperAdmin())){
            $task->status = $request->status;

            if ($request->status == 'Completado') {
                $task->completed_at = now();
            } else {
                $task->completed_at = null;
            }

            $task->save();

            return response($task, Response::HTTP_OK);
        }
        else {
            return response(['message' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }
    }
}
