<?php

namespace App\Policies;

use App\Models\HolidayPlan;
use App\Models\User;

class HolidayPlanPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct() {}

    public function show(User $user, HolidayPlan $entity)
    {
        return $this->checkIfAuthUserIsOwner($user, $entity);
    }

    public function update(User $user, HolidayPlan $entity)
    {
        return $this->checkIfAuthUserIsOwner($user, $entity);
    }

    private function checkIfAuthUserIsOwner($user, $entity)
    {
        return $user->id == $entity->user_id ?: abort(401, "Action is unauthorized.");
    }
}
