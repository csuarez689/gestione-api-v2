<?php

namespace App\Policies;

use App\Models\TeachingPlant;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class TeachingPlantPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TeachingPlant  $teachingPlant
     * @return mixed
     */
    public function view(User $user, TeachingPlant $teachingPlant)
    {
        $hasPermission = $user->school ? $user->school->id === $teachingPlant->school_id : false;

        return $this->getResponse($hasPermission);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TeachingPlant  $teachingPlant
     * @return mixed
     */
    public function update(User $user, TeachingPlant $teachingPlant)
    {
        $hasPermission = $user->school ? $user->school->id === $teachingPlant->school_id : false;

        return $this->getResponse($hasPermission);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TeachingPlant  $teachingPlant
     * @return mixed
     */
    public function delete(User $user, TeachingPlant $teachingPlant)
    {
        $hasPermission = $user->school ? $user->school->id === $teachingPlant->school_id  : false;

        return $this->getResponse($hasPermission);
    }

    private function getResponse(bool $permission)
    {
        return $permission ? Response::allow() : Response::deny('No tienes asignada esta escuela');
    }
}
