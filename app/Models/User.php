<?php

namespace App\Models;

use App\Traits\ApplyQueryParams;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, ApplyQueryParams;

    /** @var array $apiResource expose api resource corresponding class for the model */
    public $apiResourceClass = \App\Http\Resources\UserResource::class;

    /** @var array $searchable expose model attrubtes available for search */
    protected $searchable = ['name', 'last_name', 'dni', 'email'];

    /** @var array $sortable expose model attrubtes available for sort_by */
    protected $sortable = ['id', 'name', 'last_name', 'dni', 'email', 'phone', 'created_at', 'updated_at'];

    const ADMIN_USER = true;
    const REGULAR_USER = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'last_name', 'dni', 'email', 'password', 'phone'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'email_verified_at', 'created_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Set the user's email.
     *
     * @param  string  $value
     * @return void
     */
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }

    //--------------JWT--------------

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }


    //--------------Relations--------------

    public function school()
    {
        return $this->hasOne('App\Models\School');
    }
}
