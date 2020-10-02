<?php

namespace App\Models;


class OrdenMerito extends BaseModel
{
    /** @var array $apiResource expose api resource corresponding class for the model */
    public $apiResourceClass = \App\Http\Resources\BaseResource::class;

    /** @var array $searchable expose model attrubtes available for search */
    protected $searchable = ['name', 'last_name', 'cuil', 'locality', 'charge', 'title1', 'title2'];

    /** @var array $sortable expose model attrubtes available for sort_by */
    protected $sortable = ['id', 'region', 'level', 'gender', 'incumbency', 'name', 'last_name', 'cuil', 'locality', 'charge', 'title1', 'title2', 'updated_at', 'created_at'];

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];
}
