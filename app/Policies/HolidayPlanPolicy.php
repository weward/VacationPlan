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
        return $user->id == $entity->id ?: abort(401, "Action is unauthorized");
    }
}
