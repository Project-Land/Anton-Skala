<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Task;
use App\Models\Lesson;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
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
            'lesson_name' => Lesson::findOrFail($request->lesson_id)->name
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
            $numberOfCorrectAnswers = 0;

            for($i = 0; $i < $numberOfAnswers; $i++) {
                $request->answer_correct[$i] == 1 ? $numberOfCorrectAnswers++ : $numberOfCorrectAnswers;
                $answers += [
                    $i => [
                        'text' => $request->answer_text[$i],
                        'image' => $request->answer_image[$i] ?? null,
                        'audio' => $request->answer_audio[$i] ?? null,
                        'is_correct' => $request->answer_correct[$i] == 0 ? false : true,
                        'id' => $i+1
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
                    'number_of_correct_answers' => $numberOfCorrectAnswers
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



    public function storeDragAndDropType(Request $request)
    {   //dd($request->all());
        try{
            $numberOfAnswers = count($request->answer_text);
            $answers = [];
            $numberOfQuestions = count($request->question_text);
            $questions = [];


        for($i = 0; $i < $numberOfAnswers; $i++) {
            $answers += [
                $i => [
                    'text' => $request->answer_text[$i],
                    'image' => $request->answer_image[$i] ?? null,
                    'audio' => $request->answer_audio[$i] ?? null,
                    'id' => $i+1

                ]
            ];
        }

        for($i = 0; $i < $numberOfQuestions; $i++) {
            $questions += [
                $i => [
                    'text' => $request->question_text[$i],
                    'image' => $request->question_image[$i] ?? null,
                    'audio' => $request->question_audio[$i] ?? null,
                    'id' => $i+1

                ]
            ];
        }


        $content = [
            'answers' => $answers,
            'questions' => $questions
        ];
        //dd($content);
        foreach($content['answers'] as $key => $answer){
            if($answer['image']){
                $image = $answer['image'];
                $image_name = time().'.'.$image->getClientOriginalExtension();
                $image->move(public_path('material/images'), $image_name);
                $content['answers'][$key]['image'] = 'material/images/'.$image_name;
            }
           // dump($image_name);
            if($content['answers'][$key]['audio']){
                $audio = $content['answers'][$key]['audio'];
                $audio_name = time().'.'.$audio->getClientOriginalExtension();
                $audio->move(public_path('material/audio'), $audio_name);
                $content['answers'][$key]['audio'] = 'material/audio/'.$audio_name;
            }
        }

        foreach($content['questions'] as $key => $question){
            if($question['image']){
                $image = $question['image'];
                $image_name = time().'.'.$image->getClientOriginalExtension();
                $image->move(public_path('material/images'), $image_name);
                $content['questions'][$key]['image'] = 'material/images/'.$image_name;
            }
           // dump($image_name);
            if($content['questions'][$key]['audio']){
                $audio = $content['question'][$key]['audio'];
                $audio_name = time().'.'.$audio->getClientOriginalExtension();
                $audio->move(public_path('material/audio'), $audio_name);
                $content['questions'][$key]['audio'] = 'material/audio/'.$audio_name;
            }
        }


       $task = Task::create([
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


    public function storeDescriptionType(Request $request)
    {   //dd($request->lesson_id,$request->type);
        $content = [];
        $content['image'] = null;
        $content ['text'] = $request->text;
        if($request->file('image')){
            $image_name = time().'.'.$request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('material/images'), $image_name);
            $content['image'] = 'material/images/'.$image_name;
        }


        try{
            $task = Task::create([
                'lesson_id' => $request->lesson_id,
                'type' => $request->type,
                'display_order' => Task::where('lesson_id', $request->lesson_id)->count() + 1,
                'content' => json_encode($content)
            ]);

            $request->session()->flash('message', __('Zadatak je uspešno kreiran'));

        } catch(Exception $e){
            $request->session()->flash('error', __('Došlo je do greške. Pokušajte ponovo'.$e->getMessage()));
        }

        return redirect('tasks?lesson_id='.$request->lesson_id);

    }


    public function storeColumnSortingType(Request $request)
    {
        try{
            $numberOfColumns = count($request->column_text);
            $columns = [];


            for($i = 0; $i < $numberOfColumns; $i++) {

                $columns += [
                    $i => [
                        'text' => $request->column_text[$i],
                        'image' => $request->column_image[$i] ?? null,
                        'audio' => $request->column_audio[$i] ?? null,
                    ]
                ];
            }

            $content = [
                'rows' => $request->rows,
                'columns' => $columns
            ];

            foreach($content['columns'] as $key => $column){
                if($column['image']){
                    $image = $column['image'];
                    $image_name = time().rand().'.'.$image->getClientOriginalExtension();
                    $image->move(public_path('material/images'), $image_name);
                    $content['columns'][$key]['image'] = 'material/images/'.$image_name;
                }

                if($column['audio']){
                    $audio = $column['audio'];
                    $audio_name = time().rand().'.'.$audio->getClientOriginalExtension();
                    $audio->move(public_path('material/audio'), $audio_name);
                    $content['columns'][$key]['audio'] = 'material/audio/'.$audio_name;
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


    public function storeColumnSortingMultipleType(Request $request)
    {
        try{
            $numberOfAnswers = count($request->column_text);
            $answers = [];


            for($i = 0; $i < $numberOfAnswers; $i++) {

                $answers += [
                    $i => [
                        'text' => $request->column_text[$i],
                        'image' => $request->column_image[$i] ?? null,
                        'audio' => $request->column_audio[$i] ?? null,
                        'column' => $request->column_column[$i],
                        'id' => $i + 1
                    ]
                ];
            }

            $content = [

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
            $request->session()->flash('error', __('Došlo je do greške. Pokušajte ponovo'.$e->getMessage().' Linija '.$e->getLine()));
        }

        return redirect('tasks?lesson_id='.$request->lesson_id);
    }

    public function storeAddLettersType(Request $request){
        try{
            $str = $request->string;
            $str= "ds(j)(Č)";
            $clean_str = Str::replace( "(", "",  $str);
            $clean_str = Str::replace( ")", "",  $clean_str);
            $brackets_count = substr_count($str, '(') + substr_count($str, ')');

            $pattern = '/(?<=\()(\p{L}+)(?=\))/u';
            preg_match_all($pattern, $str, $matches,PREG_OFFSET_CAPTURE );

            if(!count($matches[0])) return back()->with('message', 'Unesite slova za dopunu!');

            foreach($matches[0] as $match){
                $m[]= ['value' => $match[0], 'index' => $match[1] - $brackets_count ];
            }

            foreach(str_split($clean_str) as $key=>$letter){

                $empty = Arr::exists(Arr::pluck($m, 'index'),$key);
                $letters[] = ['index'=> $key, 'value' => $letter, 'empty' => !$empty];
            }
            $image = null;
            if($request->image){
                $image = $request->image;
                $image_name = time().rand().'.'.$image->getClientOriginalExtension();
                $image->move(public_path('material/images'), $image_name);
                $image = 'material/images/'.$image_name;
            }
            $content = ['image'=> $image, 'string' => $letters, 'answers' => $m];
            Task::create([
                'lesson_id' => $request->lesson_id,
                'type' => $request->type,
                'description' => $request->description,
                'display_order' => Task::where('lesson_id', $request->lesson_id)->count() + 1,
                'content' => json_encode($content)
            ]);

            $request->session()->flash('message', __('Zadatak je uspešno kreiran'));

        } catch(Exception $e){
            $request->session()->flash('error', __('Došlo je do greške. Pokušajte ponovo'.$e->getMessage().' Linija '.$e->getLine()));
        }
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

    // public function editSpecificTask(Task $task)
    // {
    //     $object = (array)json_decode($task->content);

    //     return view('pages.tasks.types.edit.edit_'.$task->type, [
    //         'type' => $task->type,
    //         'lesson_id' => $task->lesson_id,
    //         'task' => $task,
    //         'content' => Task::hydrate($object)
    //     ]);
    // }

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
