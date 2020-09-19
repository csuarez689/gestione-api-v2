<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locality extends BaseModel
{
    /** @var array $apiResource expose api resource corresponding class for the model */
    public $apiResourceClass = \App\Http\Resources\LocalityResource::class;

    protected $fillable = ['name', 'department_id'];

    public $timestamps = false;

    public function department()
    {
        return $this->belongsTo('App\Models\Department');
    }
}
