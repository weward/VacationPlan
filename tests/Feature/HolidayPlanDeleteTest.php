<?php

namespace Tests\Feature;

use App\Models\HolidayPlan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class HolidayPlanDeleteTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_deletes_own_holiday_plan()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $task = HolidayPlan::factory()->user($user->id)->create();

        $res = $this->deleteJson(route('holiday-plans.destroy', ['holidayplan' => $task->id]));

        $res->assertStatus(204);
    }

    public function test_user_deletes_non_existing_holiday_plan()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $res = $this->deleteJson(route('holiday-plans.destroy', ['holidayplan' => 99999999]));

        $res->assertStatus(404);
    }

    public function test_user_deletes_holiday_plan_of_another_user_returns_401()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $anotherUser = User::factory()->create();
        $entityOfAnotherUser = HolidayPlan::factory()->user($anotherUser->id)->create();

        $res = $this->deleteJson(route('holiday-plans.destroy', ['holidayplan' => $entityOfAnotherUser->id]));

        $res->assertStatus(401);
    }

}
