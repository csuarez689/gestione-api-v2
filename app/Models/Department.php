<?php

namespace App\Models;


class Department extends BaseModel
{
    /** @var array $apiResource expose api resource corresponding class for the model */
    public $apiResourceClass = \App\Http\Resources\DepartmentResource::class;

    protected $fillable = ['name', 'province_id'];

    public $timestamps = false;

    public function province()
    {
        return $this->belongsTo('App\Models\Province');
    }

    public function localities()
    {
        return $this->hasMany('App\Models\Locality');
    }
}
