<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Task;
use App\Models\Lesson;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.tasks.index', [
            'subject_name' => Lesson::findOrFail($request->lesson_id)->field->subject->name,
            'subject_id' => Lesson::findOrFail($request->lesson_id)->field->subject_id,
            'field_name' => Lesson::findOrFail($request->lesson_id)->field->name,
            'field_id' => Lesson::findOrFail($request->lesson_id)->field_id,
            'lesson_id' => $request->lesson_id,
            'lesson_name' => Lesson::findOrFail($request->lesson_id)->name,
            'tasks' => Task::where('lesson_id', $request->lesson_id)->get()
        ]);
    }

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

    public function storeCorrectAnswerType(Request $request)
    {
        try{
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
                    $image_name = time().rand().'.'.$image->getClientOriginalExtension();
                    $image->move(public_path('material/images'), $image_name);
                    $content['answers'][$key]['image'] = 'material/images/'.$image_name;
                }

                if($answer['audio']){
                    $audio = $answer['audio'];
                    $audio_name = time().rand().'.'.$audio->getClientOriginalExtension();
                    $audio->move(public_path('material/audio'), $audio_name);
                    $content['answers'][$key]['audio'] = 'material/audio/'.$audio_name;
                }
            }

            Task::create([
                'lesson_id' => $request->lesson_id,
                'type' => $request->type,
                'description' => $request->description,
                'display_order' => Task::where('lesson_id', $request->lesson_id)->count() + 1,
                'content' => json_encode($content)
            ]);

            $request->session()->flash('message', __('Zadatak je uspešno kreiran'));

        } catch(Exception $e){
            $request->session()->flash('error', __('Došlo je do greške. Pokušajte ponovo'.$e->getMessage()));
        }

        return redirect('tasks?lesson_id='.$request->lesson_id);
    }


    public function show(Task $task)
    {
        //
    }

    public function editSpecificTask(Task $task)
    {
        $object = (array)json_decode($task->content);

        return view('pages.tasks.types.edit.edit_'.$task->type, [
            'type' => $task->type,
            'lesson_id' => $task->lesson_id,
            'task' => $task,
            'content' => Task::hydrate($object)
        ]);
    }

    public function edit(Task $task)
    {
        //
    }


    public function update(Request $request, Task $task)
    {
        //
    }

    public function destroy(Task $task)
    {
        //
    }
}
