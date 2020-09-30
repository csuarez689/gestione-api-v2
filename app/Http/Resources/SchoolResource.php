<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SchoolResource extends JsonResource
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
            'cue' => $this->cue,
            'address' => $this->address,
            'email' => $this->email,
            'phone' => $this->phone,
            'internal_phone' => $this->internal_phone,
            'number_students' => $this->number_students,
            'bilingual' => $this->bilingual,
            'director' => $this->director,
            'orientation' => $this->orientation,
            'updated_at' => \Carbon\Carbon::parse($this->updated_at)->format('d-m-Y H:i'),
            'locality' => new LocalityResource($this->whenLoaded('locality')),
            'user' => new UserResource($this->whenLoaded('user')),
            'ambit' => new BaseResource($this->whenLoaded('ambit')),
            'sector' => new BaseResource($this->whenLoaded('sector')),
            'type' => new BaseResource($this->whenLoaded('type')),
            'level' => new BaseResource($this->whenLoaded('level')),
            'category' => new BaseResource($this->whenLoaded('category')),
            'journey_type' => new BaseResource($this->whenLoaded('journey_type')),
            'high_school_type' => new BaseResource($this->whenLoaded('high_school_type')),
            '_links' => [
                'self' => route('api.schools.show', $this->id),
                'user' => isset($this->user_id) ? route('api.users.show', $this->user_id) : null,
                'teaching_plant' => route('api.schools.teaching_plant.index', $this->id)
            ]
        ];
    }
}
