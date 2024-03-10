<?php

namespace Tests\Feature;

use App\Models\HolidayPlan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class HolidayPlanViewTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_view_existing_holiday_plan()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $entity = HolidayPlan::factory()->user($user)->create();

        $res = $this->getJson(route('holiday-plans.show', ['holidayplan' => $entity->id]));

        $res->assertStatus(200);
        $res->assertJson(fn (AssertableJson $json) => 
            $json->has('data')
                ->where('data.title', $entity->title)
                ->etc()
        );
    }

    public function test_view_non_existing_holiday_plan()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $res = $this->getJson(route('holiday-plans.show', ['holidayplan' => 9999999999]));

        $res->assertStatus(404);
    }

    public function test_view_holiday_plan_of_another_user_fails()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $anotherUser = User::factory()->create();
        $entityOfAnotherUser = HolidayPlan::factory()->user($anotherUser)->create();

        $res = $this->getJson(route('holiday-plans.show', ['holidayplan' => $entityOfAnotherUser->id]));

        $res->assertStatus(401);
    }

}
