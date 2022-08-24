<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = ['content' => 'array'];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function next()
    {
        $tasks = $this->lesson->tasks;
        $last = $tasks->max('display_order');
        if($this->display_order == $last){
            return 0;
        }
        return $tasks->where('display_order', $this->display_order + 1)->values()[0]->id;
    }
}
