<?php

namespace App\Models;

use App\Traits\ApplyQueryParams;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use ApplyQueryParams;
}
