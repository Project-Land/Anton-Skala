<?php

namespace App\Http\Controllers\API;

use App\Models\Task;
use App\Models\User;
use App\Models\Field;
use App\Models\Lesson;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\FieldResource;
use App\Http\Resources\LessonResource;

class MaterialController extends Controller
{
    public function fields(Request $request)
    {
        $lang = in_array(Auth::user()->lang, ['sr_lat', 'sr_cir']) ? "sr" : Auth::user()->lang;

        $fields = Field::where([
            'lang' => $lang,
            'subject_id' => $request->subject_id
        ])->get();
        return response()->json(FieldResource::collection($fields));
    }

    public function lessons(Request $request)
    {
        $lessons = Lesson::where([
            'lang' => Auth::user()->lang,
            'field_id' => $request->field_id
        ])->get();
        return response()->json(LessonResource::collection($lessons));
    }

    public function lessonTasks(Request $request)
    {
        $tasks = Task::where('lesson_id', $request->lesson_id)->orderBy('display_order')->get()->first();
        return response()->json(TaskResource::collection($tasks));
    }

    public function task(Task $task)
    {
        if(!auth('sanctum')->user()){
            return response()->json(new TaskResource($task));
        }
        $lesson = $task->lesson;
        $user = Auth::user();
        $user_lesson = $user->lessons()->where('lesson_id', $lesson->id)->get();

        $user_lesson->count() ?
        $user->lessons()->wherePivot('lesson_id' , $lesson->id)->update([ 'task_id' => $task->id]) :
        $user->lessons()->attach($lesson,['task_id' => $task->id]);
        return response()->json(new TaskResource($task));
    }

    public function nextTask(Request $request, Lesson $lesson)
    {
        if(!auth('sanctum')->user()){
            return $lesson->tasks()->where('display_order', 1)->sole()->id;
        }
        $user = Auth::user();
        $user_lesson = $user->lessons()->where('lesson_id', $lesson->id)->get();

        if($user_lesson->count()){
            if($request->current_task){
                return $user_lesson[0]->pivot->task_id;
            }
            $lastTaskId = $user_lesson[0]->pivot->task_id;

        }else{
            return $lesson->tasks()->where('display_order', 1)->sole()->id;
        }

        $task = Task::find($lastTaskId);
        $tasks = $lesson->tasks;
        $maxDisplayOrder = $tasks->max('display_order');
        $currentOrderNo = $task->display_order;
        $next = $task->display_order + 1;
        if($maxDisplayOrder == $currentOrderNo){
           return $nextTask = 0;
        }
        $nextTask = $tasks->where('display_order', $next)->values()[0]->id;
        return $nextTask;

    }

    public function lessonEnd(Request $request, Lesson $lesson)
    {
        if(auth('sanctum')->user()){
            Auth::user()->lessons()->where('lesson_id', $lesson->id)->detach();
        }
        return true;
    }

    public function startOver(Request $request, Lesson $lesson)
    {
        return $lesson->tasks()->where('display_order', 1)->sole()->id;
        //$id = $lesson->tasks()->where('display_order', 1)->sole()->id;
        //$task = Task::find($id);
        //return response()->json(new TaskResource($task));
    }


}
