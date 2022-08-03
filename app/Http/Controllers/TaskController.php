<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Lesson;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('pages.tasks.index', [
            'subject_name' => Lesson::findOrFail($request->lesson_id)->field->subject->name,
            'subject_id' => Lesson::findOrFail($request->lesson_id)->field->subject_id,
            'field_name' => Lesson::findOrFail($request->lesson_id)->field->name,
            'field_id' => Lesson::findOrFail($request->lesson_id)->field_id,
            'lesson_id' => $request->lesson_id,
            'lesson_name' => Lesson::findOrFail($request->lesson_id)->name,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('pages.tasks.create', ['lesson_id' => $request->lesson_id]);
    }

    public function createSpecificTask(Request $request)
    {
        return view('pages.tasks.types.'.$request->type, [
            'type' => $request->type,
            'lesson_id' => $request->lesson_id
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        //
    }
}
