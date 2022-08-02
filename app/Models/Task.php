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
}
