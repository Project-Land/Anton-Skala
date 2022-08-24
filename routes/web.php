<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\API\MaterialController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('dashboard');

    Route::resource('subjects', SubjectController::class);
    Route::resource('fields', FieldController::class);
    Route::resource('lessons', LessonController::class);
    Route::resource('students', StudentController::class);

    // Tasks
    Route::resource('tasks', TaskController::class);
    Route::get('create-task', [TaskController::class, 'createSpecificTask'])->name('tasks.type');
    // Route::get('edit-task/{task}', [TaskController::class, 'editSpecificTask'])->name('tasks.edit');

    Route::post('tasks/store-correct-answer-type', [TaskController::class, 'storeCorrectAnswerType'])->name('tasks.store-correct-answer-type');
    Route::post('tasks/store-drag-and-drop', [TaskController::class, 'storeDragAndDropType'])->name('tasks.store-drag-and-drop-type');
    Route::post('tasks/store-description', [TaskController::class, 'storeDescriptionType'])->name('tasks.store-description-type');
    Route::post('tasks/store-column-sorting', [TaskController::class, 'storeColumnSortingType'])->name('tasks.store-column-sorting-type');
    Route::post('tasks/store-column-sorting-multiple', [TaskController::class, 'storeColumnSortingMultipleType'])->name('tasks.store-column-sorting-multiple-type');
});


require __DIR__.'/auth.php';
