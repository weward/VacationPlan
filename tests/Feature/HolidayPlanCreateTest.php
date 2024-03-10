<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class HolidayPlanCreateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * As an authenticated user,
     * When creating a holiday plan with valid inputs,
     * User must receive a 200 response with the data.
     */
    public function test_user_creates_a_new_holiday_plan()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $title = "Test";
        $description = "Sample description";
        $date = today()->format('Y-m-d');
        $location = "123 Sesame St. Sample City, Republic of Antarctica";
        $participants = [
            "Mr. Valdez",
            "Mr. Diego I. Santos",
        ];
        
        $res = $this->postJson(route('holiday-plans.store'), [
            'title' => $title,
            'description' => $description,
            'date' => $date,
            'location' => $location,
            'participants' => $participants,
        ]);

        $res->assertStatus(201);
        $res->assertJson(
            fn (AssertableJson $json) =>
            $json->has('data')
                ->where('data.title', $title)
                ->etc()
        );
        $res->assertJsonCount(count($participants), 'data.participants');
    }

    public function test_user_creates_a_new_holiday_plan_with_invalid_date_format()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $title = "Test";
        $description = "Sample description";
        $date = today();
        $location = "123 Sesame St. Sample City, Republic of Antarctica";
        $participants = [
            "Mr. Valdez",
            "Mr. Diego I. Santos",
        ];

        $res = $this->postJson(route('holiday-plans.store'), [
            'title' => $title,
            'description' => $description,
            'date' => $date,
            'location' => $location,
            'participants' => $participants,
        ]);

        $res->assertStatus(422);
        $res->assertJson(
            fn (AssertableJson $json) =>
            $json->has('errors')
            ->where('errors.date', ["The date field must match the format Y-m-d."])
                ->etc()
        );
    }

    public function test_user_creates_a_new_holiday_plan_with_no_participants()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $title = "Test";
        $description = "Sample description";
        $date = today()->format('Y-m-d');
        $location = "123 Sesame St. Sample City, Republic of Antarctica";

        $res = $this->postJson(route('holiday-plans.store'), [
            'title' => $title,
            'description' => $description,
            'date' => $date,
            'location' => $location,
        ]);

        $res->assertStatus(201);
        $res->assertJson(
            fn (AssertableJson $json) =>
            $json->has('data')
                ->where('data.title', $title)
                ->etc()
        );
        $res->assertJsonCount(0, 'data.participants');
    }
}
