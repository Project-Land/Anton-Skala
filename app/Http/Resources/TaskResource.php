<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{

    public function toArray($request)
    {
        $totalTasks = $this->lesson->tasks()->count();

        return [
            'id' => $this->id,
            'lesson_id' => $this->lesson_id,
            'type' => $this->type,
            'description' => $this->description,
            'display_order' => $this->display_order,
            'content' => json_decode($this->content),
            'next_task_id' =>  $this->next(),
            //'answers'=> json_decode($this->content, TRUE)['answers'],
            //'questions'=> json_decode($this->content, TRUE)['questions'],
            //'answers_shuffle' =>
            //'questions_shuffle' =>
            //'borders_in_color' =>
            //'no_of_correct_answers =>'
        ];
    }
}
