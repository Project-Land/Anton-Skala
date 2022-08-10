<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\MaterialController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function () {

    // Material
    Route::get('/fields', [MaterialController::class, 'fields']);
    Route::get('/lessons', [MaterialController::class, 'lessons']);
    Route::get('/tasks', [MaterialController::class, 'lessonTasks']);
    Route::get('/task/{task}', [MaterialController::class, 'task'])->missing(function () {
        return response(['message' => 'Task not found'], 404);
    Route::get('/next-task', [MaterialController::class, 'nextTask']);
    });

    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/auth', [AuthController::class, 'show']);
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
