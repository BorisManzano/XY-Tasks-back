<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\ReportController;
use Illuminate\Support\Facades\Route;


Route::post('login', [AuthController::class, 'login']);
Route::post('recoverPassword', [AuthController::class,'recoverPassword']);
Route::put('updatePassword', [AuthController::class, 'updatePassword']);
Route::get('allComments/{task_id}', [CommentController::class, 'allComments' ]);

Route::group(['middleware' => ['auth:sanctum']], function(){
    
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'checkAuthStatus']);
    Route::put('changeStatus', [TaskController::class, 'changeStatus']);
    Route::post('newComment', [CommentController::class, 'newComment']);
    Route::get('comments/{comment}/attachments', [CommentController::class, 'getAttachments'])->name('comments.attachments');
    Route::get('attachments/download/{attachment}', [CommentController::class, 'downloadAttachment'])->name('attachments.download');
    Route::get('allEmployeesTasks', [AuthController::class, 'allEmployeesTasks']);
    Route::get('employeeTasks', [AuthController::class, 'employeeTasks']);
    Route::delete('deleteComment/{comment}', [CommentController::class, 'deleteComment'])->middleware('can:delete,comment');
});

Route::group(['middleware' => ['auth:sanctum', 'super_admin']], function(){

    Route::get('reports/generate', [ReportController::class, 'downloadPDF'])->name('download-pdf');
    Route::get('allEmployees', [AuthController::class, 'allEmployees']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('newTask', [TaskController::class, 'newTask']);
    Route::put('changeEmployee/{id}', [TaskController::class, 'changeEmployee']);
    Route::delete('deleteTask', [TaskController::class, 'deleteTask']);

});