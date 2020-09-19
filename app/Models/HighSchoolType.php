<?php

namespace App\Models;

class HighSchoolType extends BaseModel
{
    protected $fillable = ['name'];

    public $timestamps = false;

    //--------------Relations--------------

    public function schools()
    {
        return $this->hasMany('App\Models\School');
    }
}
