<?php

namespace App\Models;


class SchoolAmbit extends BaseModel
{
    protected $fillable = ['name'];

    public $timestamps = false;

    //--------------Relations--------------

    public function schools()
    {
        return $this->hasMany('App\Models\School');
    }
}
