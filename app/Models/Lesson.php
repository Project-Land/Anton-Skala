<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function field()
    {
        return $this->belongsTo(Field::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('task_id');
    }

    public function nextTask()
    {
        if(!auth('sanctum')->user()){
            return $this->tasks()->where('display_order', 1)->sole()->id;
        }
        $user = auth('sanctum')->user();
        $user_lesson = $user->lessons()->where('lesson_id', $this->id)->get();

        if(!$user_lesson->count()){
            return $this->tasks()->where('display_order', 1)->sole()->id;
        }
        $lastTaskId = $user_lesson[0]->pivot->task_id;

        $task = Task::find($lastTaskId);
        $tasks = $this->tasks;
        $maxDisplayOrder = $tasks->max('display_order');
        $currentOrderNo = $task->display_order;
        $next = $task->display_order + 1;
        if($maxDisplayOrder == $currentOrderNo){
           //return $nextTask = 0;
           return $this->tasks()->where('display_order', 1)->sole()->id;
        }
        $nextTask = $tasks->where('display_order', $next)->values()[0]->id;
        return $nextTask;
    }
}
