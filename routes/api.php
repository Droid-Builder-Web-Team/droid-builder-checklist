<?php

use App\Http\Controllers\ToDoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/todo-list', [ToDoController::class, 'index']);
Route::middleware('auth:sanctum')->prefix('/todo')->group(function () {
    Route::post('/store', [ToDoController::class, 'store']);
    Route::put('/{todItemId}', [ToDoController::class, 'update']);
    Route::delete('/{todoItemId', [ToDoController::class, 'destroy']);
});
