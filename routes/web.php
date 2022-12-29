<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;

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
    Route::get('students/{id}/report/{lessonID}', [StudentController::class, 'showReport'])->name('students.report');
    Route::resource('teachers', TeacherController::class);
    Route::resource('schools', SchoolController::class);

    // Tasks
    Route::resource('tasks', TaskController::class);
    Route::get('create-task', [TaskController::class, 'createSpecificTask'])->name('tasks.type');
    // Route::get('edit-task/{task}', [TaskController::class, 'editSpecificTask'])->name('tasks.edit');

    Route::post('tasks/store-correct-answer-type', [TaskController::class, 'storeCorrectAnswerType'])->name('tasks.store-correct-answer-type');
    Route::post('tasks/store-drag-and-drop', [TaskController::class, 'storeDragAndDropType'])->name('tasks.store-drag-and-drop-type');
    Route::post('tasks/store-description', [TaskController::class, 'storeDescriptionType'])->name('tasks.store-description-type');
    Route::post('tasks/store-column-sorting', [TaskController::class, 'storeColumnSortingType'])->name('tasks.store-column-sorting-type');
    Route::post('tasks/store-column-sorting-multiple', [TaskController::class, 'storeColumnSortingMultipleType'])->name('tasks.store-column-sorting-multiple-type');
    Route::post('tasks/store-add-letter', [TaskController::class, 'storeAddLetterType'])->name('tasks.store-add-letter-type');
    Route::post('tasks/store-sentence', [TaskController::class, 'storeSentenceType'])->name('tasks.store-sentence-type');
    Route::post('tasks/store-complete-the-sentence', [TaskController::class, 'storeCompleteTheSentenceType'])->name('tasks.store-complete-the-sentence-type');
    Route::post('tasks/store-story', [TaskController::class, 'storeStoryType'])->name('tasks.store-story-type');
    Route::post('tasks/store-connect-lines', [TaskController::class, 'storeConnectLinesType'])->name('tasks.store-connect-lines-type');
});

require __DIR__ . '/auth.php';
