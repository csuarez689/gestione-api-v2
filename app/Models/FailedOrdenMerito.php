<?php

namespace App\Models;



class FailedOrdenMerito extends BaseModel
{
    /** @var array $apiResource expose api resource corresponding class for the model */
    public $apiResourceClass = \App\Http\Resources\FailedOrdenMeritoResource::class;

    /** @var array $searchable expose model attrubtes available for search */
    protected $searchable = ['name', 'last_name', 'cuil', 'locality', 'charge', 'title1', 'title2', 'year', 'incumbency'];

    /** @var array $sortable expose model attrubtes available for sort_by */
    protected $sortable = ['id', 'region', 'level', 'gender', 'incumbency', 'name', 'last_name', 'cuil', 'locality', 'charge', 'title1', 'title2', 'updated_at', 'created_at', 'year'];

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];


    /**
     * Set last_name.
     *
     * @param  string  $value
     * @return void
     */
    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = strtoupper($value);
    }


    /**
     * Set incumbency.
     *
     * @param  string  $value
     * @return void
     */
    public function setIncumbencyAttribute($value)
    {
        $this->attributes['incumbency'] = strtoupper($value);
    }

    /**
     * Set level.
     *
     * @param  string  $value
     * @return void
     */
    public function setLevelAttribute($value)
    {
        $this->attributes['level'] = strtoupper($value);
    }

    /**
     * Set gender.
     *
     * @param  string  $value
     * @return void
     */
    public function setGenderAttribute($value)
    {
        $this->attributes['gender'] = strtoupper($value);
    }

    /**
     * Set locality.
     *
     * @param  string  $value
     * @return void
     */
    public function setLocalityAttribute($value)
    {
        $this->attributes['locality'] = strtoupper($value);
    }

    /**
     * Set charge.
     *
     * @param  string  $value
     * @return void
     */
    public function setChargeAttribute($value)
    {
        $this->attributes['charge'] = strtoupper($value);
    }

    /**
     * Set title1.
     *
     * @param  string  $value
     * @return void
     */
    public function setTitle1Attribute($value)
    {
        $this->attributes['title1'] = strtoupper($value);
    }

    /**
     * Set title2.
     *
     * @param  string  $value
     * @return void
     */
    public function setTitle2Attribute($value)
    {
        $this->attributes['title2'] = strtoupper($value);
    }

    /**
     * Get validation errors.
     *
     * @param  string  $value
     * @return void
     */
    public function getErrorsAttribute($value)
    {
        return json_decode($value);
    }
}
