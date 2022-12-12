<?php

namespace App\Http\Controllers\API;

use Exception;
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
        $lang = Auth::check() ? (in_array(Auth::user()->lang, ['sr_lat', 'sr_cir']) ? "sr" : Auth::user()->lang) : $request->lang;

        $fields = Field::where([
            'lang' => $lang,
            'subject_id' => $request->subject_id
        ])->get();
        return response()->json(FieldResource::collection($fields));
    }

    public function lessons(Request $request)
    {
        $lang = Auth::check() ? Auth::user()->lang : $request->lang;

        $lessons = Lesson::where([
            'lang' => $lang,
            'field_id' => $request->field_id
        ])->get();
        return response()->json(LessonResource::collection($lessons));
    }

    public function lessonTasks(Request $request)
    {
        $tasks = Task::where('lesson_id', $request->lesson_id)
            ->orderBy('display_order')
            ->get();

        if ($tasks->isEmpty()) {
            return response()->json(['message' => 'Lesson does not exist or has no tasks yet'], 400);
        }

        return response()->json(new TaskResource($tasks->first()));
    }

    public function task(Request $request, Task $task)
    {
        if (!auth('sanctum')->user()) {
            return response()->json(new TaskResource($task));
        }

        $user = auth('sanctum')->user();

        $lesson = $task->lesson;

        if ($request->previous) {
            $user_lesson = $user->lessons()->where('lesson_id', $lesson->id)->get();
            $user_lesson->count() ?
                $user->lessons()->wherePivot('lesson_id', $lesson->id)->update(['task_id' => $task->id]) :
                $user->lessons()->attach($lesson, ['task_id' => $task->id]);
        }

        return response()->json(new TaskResource($task));
    }

    public function nextTask(Request $request, Lesson $lesson)
    {
        if (!auth('sanctum')->user()) {
            return $lesson->tasks()->where('display_order', 1)->sole()->id;
        }

        $user = auth('sanctum')->user();
        $user_lesson = $user->lessons()->where('lesson_id', $lesson->id)->get();

        if ($user_lesson->isEmpty()) {
            return $lesson->tasks()->where('display_order', 1)->sole()->id;
        } else {
            if ($request->current_task) {
                return $user_lesson[0]->pivot->task_id;
            }
            $lastTaskId = $user_lesson[0]->pivot->task_id;
        }

        $task = Task::find($lastTaskId);
        $tasks = $lesson->tasks;
        $maxDisplayOrder = $tasks->max('display_order');
        $currentOrderNo = $task->display_order;
        $next = $task->display_order + 1;
        if ($maxDisplayOrder == $currentOrderNo) {
            return 0;
        }

        $nextTaskId = $tasks->where('display_order', $next)->values()[0]->id;

        $user->lessons()->wherePivot('lesson_id', $lesson->id)->update(['task_id' => $nextTaskId]);
        return $nextTaskId;
    }

    public function lessonEnd(Request $request, Lesson $lesson)
    {
        if (auth('sanctum')->user()) {
            // proveriti da li treba detach zbog statistike ucenika ??
            //Auth::user()->lessons()->where('lesson_id', $lesson->id)->detach();
        }
        return true;
    }

    public function startOver(Request $request, Lesson $lesson)
    {
        return $lesson->tasks()->where('display_order', 1)->sole()->id;
    }

    public function updateTaskUserStats(Request $request)
    {
        $user = auth('sanctum')->user();

        $task = Task::find($request->task_id);
        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        try {
            if (!$user->tasks()->updateExistingPivot($task, ['elapsed_time' => $request->elapsed_time])) {
                $user->tasks()->attach($task, [
                    'elapsed_time' => $request->elapsed_time,
                    //'no_of_attempts' => $request->no_of_attempts
                ]);
            }

            //Update lessonUser table to keep track of last task user has completed
            $user_lesson = $user->lessons()->where('lesson_id', $task->lesson->id)->get();
            $user_lesson->count() ?
                $user->lessons()->wherePivot('lesson_id', $task->lesson->id)->update(['task_id' => $request->task_id]) :
                $user->lessons()->attach($task->lesson, ['task_id' => $task->id]);

            return response()->json(['message' => 'User statistic successfully updated'], 201);
        } catch (Exception $e) {
            return response()->json(['message' => 'There has been an error: ' . $e->getMessage()], 400);
        }
    }
}
