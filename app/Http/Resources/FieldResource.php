<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FieldResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->image,
            'lang' => $this->lang,
            'subject_name' => $this->subject->name,
            'subject_id' => $this->subject_id,
        ];
    }
}
