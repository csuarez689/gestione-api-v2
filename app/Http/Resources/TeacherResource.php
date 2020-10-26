<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TeacherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'last_name' => $this->last_name,
            'cuil' => $this->cuil,
            'gender' => $this->gender,
            'locality' => new LocalityResource($this->whenLoaded('locality')),
            'updated_at' => \Carbon\Carbon::parse($this->updated_at)->format('d-m-Y H:i'),
        ];
    }
}
