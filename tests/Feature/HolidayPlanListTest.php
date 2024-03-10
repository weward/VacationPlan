<?php

namespace Tests\Feature;

use App\Models\HolidayPlan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class HolidayPlanListTest extends TestCase
{
    use RefreshDatabase;

    public function test_lists_own_tasks()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $ownDataCount = 10;

        // Holiday plans with other users
        HolidayPlan::factory()->count(10)->create();
        // Holiday plans with authenticated user
        HolidayPlan::factory()->count($ownDataCount)->user($user)->create();

        $res = $this->getJson(route('holiday-plans.index'));

        $res->assertStatus(200);
        $res->assertJson(fn (AssertableJson $json) =>
            $json->has('data')
                ->where('meta.current_page', 1)
                ->etc()
        );
        
        $res->assertJsonCount($ownDataCount, 'data');
    }
}
