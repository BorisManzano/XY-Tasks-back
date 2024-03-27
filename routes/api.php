<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\TaskController;
use Illuminate\Support\Facades\Route;


Route::post('login', [AuthController::class, 'login']);
Route::post('recoverPassword', [AuthController::class,'recoverPassword']);
Route::put('updatePassword', [AuthController::class, 'updatePassword']);

Route::group(['middleware' => ['auth:sanctum']], function(){
    
    Route::post('logout', [AuthController::class, 'logout']);
    Route::put('changeStatus', [TaskController::class, 'changeStatus']);
    Route::post('newComment', [CommentController::class, 'newComment']);
    Route::delete('deleteComment/{comment}', [CommentController::class, 'deleteComment'])->middleware('can:delete,comment');
    
});    
    
Route::group(['middleware' => ['auth:sanctum', 'super_admin']], function(){
        
    Route::get('employeeTasks', [AuthController::class, 'employeeTasks']);
    Route::get('allEmployees', [AuthController::class, 'allEmployees']);
    Route::get('allEmployeesTasks', [AuthController::class, 'allEmployeesTasks']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('newTask', [TaskController::class, 'newTask']);
    Route::put('changeEmployee/{id}', [TaskController::class, 'changeEmployee']);
    Route::delete('deleteTask', [TaskController::class, 'deleteTask']);

});
