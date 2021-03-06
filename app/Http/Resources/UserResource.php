<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'dni' => $this->dni,
            'email' => $this->email,
            'phone' => $this->phone,
            'updated_at' => \Carbon\Carbon::parse($this->updated_at)->format('d-m-Y H:i'),
            'school' =>  new SchoolResource($this->whenLoaded('school')),
            'isAdmin' => $this->isAdmin,
            'school_id' => $this->school_id,
        ];
    }
}
