<?php

namespace App\Http\Controllers\API;

use App\Models\Task;
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
        Auth::user()->last_task = $task->id;
        Auth::user()->save();
        return response()->json(new TaskResource($task));
    }

    public function nextTask(Request $request)
    {
        $task = Task::find(Auth::user()->last_task);
        $lesson= $task->lesson;
        $maxDisplayOrder = $lesson->tasks()->max('display_order');
        $currentOrderNo = $task->order_no;
        $next = $task->display_order + 1;
        if($maxDisplayOrder == $currentOrderNo){
             return null;
        }
        $nextTask = $lesson->tasks()->where('display_order', $next)->get();
        return response()->json(TaskResource::collection($nextTask));
    }
}
