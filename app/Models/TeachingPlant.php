<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Validator;

class TeachingPlant extends BaseModel
{
    use HasFactory;

    /** @var array $apiResource expose api resource corresponding class for the model */
    public $apiResourceClass = \App\Http\Resources\TeachingPlantResource::class;

    /** @var array $searchable expose model attrubtes available for search */
    protected $searchable = ['year', 'division', 'subject', 'teacher_title', 'teacher_category_title'];

    /** @var array $sortable expose model attrubtes available for sort_by */
    protected $sortable = ['id', 'year', 'division', 'subject', 'teacher_title', 'teacher_category_title', 'updated_at', 'created_at'];

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'schools_teachers';

    protected $casts = [
        'montly_hours' => 'float'
    ];

    /**
     * Set the teachingplant's subject.
     *
     * @param  string  $value
     * @return void
     */
    public function setSubjectAttribute($value)
    {
        $this->attributes['subject'] = strtoupper($value);
    }

    /**
     * Set the teachingplant's teacher_title.
     *
     * @param  string  $value
     * @return void
     */
    public function setTeacherTitleAttribute($value)
    {
        $this->attributes['teacher_title'] = strtoupper($value);
    }

    /**
     * Set the teachingplant's teacher_category_title.
     *
     * @param  string  $value
     * @return void
     */
    public function setTeacherCategoryTitleAttribute($value)
    {
        $this->attributes['teacher_category_title'] = strtoupper($value);
    }

    /**
     * Set the teachingplant's teacher_category_title.
     *
     * @param  string  $value
     * @return void
     */
    public function setDivisionAttribute($value)
    {
        $this->attributes['division'] = strtoupper($value);
    }

    /**
     * Local scope a query to filter by year and division.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilterYearDivision($query)
    {
        $yearValidator = Validator::make(request()->query(), ['year' => 'digits:1']);
        $divisionValidator = Validator::make(request()->query(), ['division' => 'alpha|min:1|max:1']);

        $year = !$yearValidator->fails() ? request()->year : '%';
        $division = !$divisionValidator->fails() ? request()->division : '%';
        return $query->where([
            ['year', 'LIKE', $year],
            ['division', 'LIKE', $division],
        ]);
    }

    //--------------Relations--------------

    public function school()
    {
        return $this->belongsTo('App\Models\School');
    }

    public function teacher()
    {
        return $this->belongsTo('App\Models\Teacher');
    }

    public function job_state()
    {
        return $this->belongsTo('App\Models\JobState');
    }
}
