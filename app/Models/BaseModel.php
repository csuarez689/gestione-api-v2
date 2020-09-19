<?php

namespace App\Models;

use App\Traits\ApplyQueryParams;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use ApplyQueryParams;

    /** @var array $searchable expose model attrubtes available for search */
    protected $searchable = [];

    /** @var array $sortable expose model attrubtes available for sort_by */
    protected $sortable = [];
}
