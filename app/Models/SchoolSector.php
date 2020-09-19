<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolSector extends BaseModel
{
    /** @var array $apiResource expose api resource corresponding class for the model */
    public $apiResourceClass = \App\Http\Resources\SchoolSectorResource::class;

    /** @var array $searchable expose model attrubtes available for search */
    protected $searchable = ['name'];

    /** @var array $sortable expose model attrubtes available for sort_by */
    protected $sortable = ['id', 'name'];

    protected $fillable = ['name'];

    public $timestamps = false;

    //--------------Relations--------------

    public function schools()
    {
        return $this->hasMany('App\Models\School');
    }
}
