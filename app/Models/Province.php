<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends BaseModel
{
    /** @var array $apiResource expose api resource corresponding class for the model */
    public $apiResourceClass = \App\Http\Resources\ProvinceResource::class;

    protected $fillable = ['name'];

    public $timestamps = false;

    public function departments()
    {
        return $this->hasMany('App\Models\Department');
    }
}
