<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Lesson;
use Illuminate\Support\Arr;
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
    public function storeCorrectAnswerType(Request $request)
    {
        //dd($request->all());
        $numberOfAnswers = count($request->answer_text);
        $answers = [];

        for($i = 0; $i < $numberOfAnswers; $i++) {
            $answers += [
                $i => [
                    'text' => $request->answer_text[$i],
                    'image' => $request->answer_image[$i] ?? null,
                    'audio' => $request->answer_audio[$i] ?? null,
                    'is_correct' => $request->answer_correct[$i] == 0 ? false : true
                ]
            ];
        }

        // provera ako nije izabran nijedan tačan odgovor
        if(!count(collect($answers)->where('is_correct', true))){
            return redirect()->back()->withInput()->with(['error' => __('Izaberite bar jedan tačan odgovor')]);
        }

        if($request->question_image){
            $image = $request->question_image;
            $image_name = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('material/images'), $image_name);
            $question_image_path = 'material/images/'.$image_name;
        }
        else{
            $question_image_path = null;
        }

        if($request->question_audio){
            $audio = $request->question_audio;
            $audio_name = time().'.'.$audio->getClientOriginalExtension();
            $audio->move(public_path('material/audio'), $audio_name);
            $question_audio_path = 'material/audio/'.$audio_name;
        }
        else{
            $question_audio_path = null;
        }

        $content = [
            'question' => [
                'text' => $request->question_text,
                'image' => $question_image_path,
                'audio' => $question_audio_path,
            ],
            'answers' => $answers
        ];

        foreach($content['answers'] as $key => $answer){
            if($answer['image']){
                $image = $answer['image'];
                $image_name = time().'.'.$image->getClientOriginalExtension();
                $image->move(public_path('material/images'), $image_name);
                $content['answers'][$key]['image'] = 'material/images/'.$image_name;
            }
            dump($image_name);
            if($content['answers'][$key]['audio']){
                $audio = $content['answers'][$key]['audio'];
                $audio_name = time().'.'.$audio->getClientOriginalExtension();
                $audio->move(public_path('material/audio'), $audio_name);
                $content['answers'][$key]['audio'] = 'material/audio/'.$audio_name;
            }
        }

        dd($content);
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
