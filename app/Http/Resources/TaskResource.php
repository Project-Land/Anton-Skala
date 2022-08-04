<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'lesson_id' => $this->lesson_id,
            'type' => $this->type,
            'description' => $this->description,
            'content' => $this->content,
            'display_order' => $this->display_order
        ];
    }
}
