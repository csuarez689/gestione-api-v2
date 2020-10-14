<?php

namespace App\Policies;

use App\Models\School;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class SchoolPolicy
{
    use HandlesAuthorization;
    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\School  $school
     * @return mixed
     */
    public function view(User $user, School $school)
    {

        $isAdmin = $user->isAdmin;
        $hasPermission = $user->school ?? $user->school->id === $school->id;

        return ($isAdmin || $hasPermission) ? Response::allow() : Response::deny('No tienes asignada esta escuela');
    }
}
