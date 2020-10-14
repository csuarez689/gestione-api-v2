<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FailedOrdenMeritoResource extends JsonResource
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
            "id" => $this->id,
            "incumbency" => $this->incumbency ? $this->incumbency : 'Sin Especificar',
            "region" => $this->region,
            "level" => $this->level,
            "last_name" => $this->last_name,
            "name" => $this->name,
            "cuil" => $this->cuil,
            "gender" => $this->gender,
            "locality" => $this->locality,
            "charge" => $this->charge,
            "title1" => $this->title1,
            "title2" => $this->title2,
            "year" => $this->year,
            "errors" => json_decode($this->errors),
            "created_at" => \Carbon\Carbon::parse($this->created_at)->format('d-m-Y H:i'),
            "updated_at" => \Carbon\Carbon::parse($this->updated_at)->format('d-m-Y H:i'),
        ];
    }
}
