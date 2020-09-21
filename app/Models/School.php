<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class School extends BaseModel
{
    use HasFactory;

    /** @var array $apiResource expose api resource corresponding class for the model */
    public $apiResourceClass = \App\Http\Resources\SchoolResource::class;

    /** @var array $searchable expose model attrubtes available for search */
    protected $searchable = ['name', 'cue', 'email', 'director', 'orientation'];

    /** @var array $sortable expose model attrubtes available for sort_by */
    protected $sortable = ['id', 'name', 'cue', 'email', 'director', 'orientation', 'updated_at', 'created_at'];

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'bilingual' => 'boolean'
    ];


    //--------------Relations--------------

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function ambit()
    {
        return $this->belongsTo('App\Models\SchoolAmbit');
    }

    public function sector()
    {
        return $this->belongsTo('App\Models\SchoolSector');
    }

    public function type()
    {
        return $this->belongsTo('App\Models\SchoolType');
    }

    public function level()
    {
        return $this->belongsTo('App\Models\SchoolLevel');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\SchoolCategory');
    }

    public function journey_type()
    {
        return $this->belongsTo('App\Models\JourneyType');
    }

    public function locality()
    {
        return $this->belongsTo('App\Models\Locality');
    }

    public function high_school_type()
    {
        return $this->belongsTo('App\Models\HighSchoolType');
    }
}
