<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LessonResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'lang' => $this->lang,
            'field_name' => $this->field->name,
            'field_id' => $this->field_id
        ];
    }
}
