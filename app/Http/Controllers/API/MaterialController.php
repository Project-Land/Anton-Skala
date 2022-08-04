<?php

namespace App\Http\Controllers\API;

use App\Models\Task;
use App\Models\Field;
use App\Models\Lesson;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Http\Resources\FieldResource;
use App\Http\Resources\LessonResource;

class MaterialController extends Controller
{
    public function fields(Request $request)
    {
        $lang = in_array($request->lang, ['sr_lat', 'sr_cir']) ? "sr" : $request->lang;

        $fields = Field::where([
            'lang' => $lang,
            'subject_id' => $request->subject_id
        ])->get();
        return response()->json(FieldResource::collection($fields));
    }

    public function lessons(Request $request)
    {
        $lessons = Lesson::where([
            'lang' => $request->lang,
            'field_id' => $request->field_id
        ])->get();
        return response()->json(LessonResource::collection($lessons));
    }

    public function lessonTasks(Request $request)
    {
        $tasks = Task::where('lesson_id', $request->lesson_id)->get();
        return response()->json(TaskResource::collection($tasks));
    }

    public function task(Task $task)
    {
        return response()->json(new TaskResource($task));
    }
}
