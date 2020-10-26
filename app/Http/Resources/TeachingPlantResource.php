<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TeachingPlantResource extends JsonResource
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
            'year' => $this->year,
            'division' => $this->division,
            'subject' => $this->subject,
            'monthly_hours' => $this->monthly_hours,
            'teacher_title' => $this->teacher_title,
            'teacher_category_title' => $this->teacher_category_title,
            'updated_at' => \Carbon\Carbon::parse($this->updated_at)->format('d-m-Y H:i'),
            'school' => new SchoolResource($this->whenLoaded('school')),
            'teacher' => new TeacherResource($this->whenLoaded('teacher')),
            'job_state' => new BaseResource($this->whenLoaded('job_state')),
        ];
    }
}
