<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Teacher extends BaseModel
{
    use HasFactory;

    /** @var array $apiResource expose api resource corresponding class for the model */
    public $apiResourceClass = \App\Http\Resources\TeacherResource::class;

    /** @var array $searchable expose model attrubtes available for search */
    protected $searchable = ['name', 'last_name', 'cuil'];

    /** @var array $sortable expose model attrubtes available for sort_by */
    protected $sortable = ['id', 'name', 'last_name', 'cuil', 'gender', 'created_at', 'updated_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'last_name', 'cuil', 'gender', 'locality_id'
    ];

    //--------------Relations--------------

    public function locality()
    {
        return $this->belongsTo('App\Models\Locality');
    }

    public function jobs()
    {
        return $this->hasMany('App\Models\SchoolJobs');
    }
}
