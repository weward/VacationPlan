<?php

namespace Tests\Feature;

use App\Models\HolidayPlan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class HolidayPlanUpdateTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_user_updates_own_holiday_plan()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $entity = HolidayPlan::factory()->user($user)->create();
        $oldTitle = $entity->title;
        $newTitle = 'Edited Title';
        $newDescription = "This is an updated description";
        $newDate = today()->format('Y-m-d');
        $newLocation = "New Location";

        $this->assertNotEquals($oldTitle, $newTitle);

        $res = $this->putJson(route('holiday-plans.update', ['holidayplan' => $entity->id]), [
            'title' => $newTitle,
            'description' => $newDescription,
            'date' => $newDate,
            'location' => $newLocation,
        ]);

        $res->assertStatus(200);
        $res->assertJson(
            fn (AssertableJson $json) =>
            $json->has('data')
                ->where('data.title', $newTitle)
                ->etc()
        );
    }

    public function test_user_updates_own_holiday_plan_with_invalid_input_fails()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $entity = HolidayPlan::factory()->user($user)->create();
        $newTitle = '';
        $newDescription = '';

        $this->assertNotEquals($newTitle, $entity->title);

        $res = $this->putJson(route('holiday-plans.update', ['holidayplan' => $entity->id]), [
            'title' => $newTitle,
            'description' => $newDescription,
        ]);

        $res->assertStatus(422);
    }

    public function test_user_updates_own_holiday_plan_and_removes_participants()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $entity = HolidayPlan::factory()->user($user)->create();
        $oldTitle = $entity->title;
        $newTitle = 'Edited Title';
        $newDescription = "This is an updated description";
        $newDate = today()->format('Y-m-d');
        $newLocation = "New Location";
        $newParticipants = [];

        $this->assertNotEquals($oldTitle, $newTitle);

        $res = $this->putJson(route('holiday-plans.update', ['holidayplan' => $entity->id]), [
            'title' => $newTitle,
            'description' => $newDescription,
            'date' => $newDate,
            'location' => $newLocation,
            'participants' => $newParticipants,
        ]);

        $res->assertStatus(200);
        $res->assertJson(
            fn (AssertableJson $json) =>
            $json->has('data')
                ->where('data.title', $newTitle)
                ->where('data.participants', $newParticipants)
                ->etc()
        );
    }

    public function test_user_updates_own_holiday_plan_and_adds_to_empty_participants()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $entity = HolidayPlan::factory()->user($user)->create(['participants' => []]);
        $newTitle = 'Edited Title';
        $newDescription = "This is an updated description";
        $newDate = today()->format('Y-m-d');
        $newLocation = "New Location";
        $oldParticipants = $entity->participants;

        $this->assertEquals($oldParticipants, []);

        $newParticipants = [
            'Mr. Valdez',
            'Mr. Mondragon'
        ];

        $this->assertNotEquals($oldParticipants, $newParticipants);

        $res = $this->putJson(route('holiday-plans.update', ['holidayplan' => $entity->id]), [
            'title' => $newTitle,
            'description' => $newDescription,
            'date' => $newDate,
            'location' => $newLocation,
            'participants' => $newParticipants,
        ]);

        $res->assertStatus(200);
        $res->assertJson(
            fn (AssertableJson $json) =>
            $json->has('data')
            ->where('data.title', $newTitle)
                ->where('data.participants', $newParticipants)
                ->etc()
        );
    }

    public function test_user_updates_own_holiday_plan_and_adds_new_participants()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $entity = HolidayPlan::factory()->user($user)->create();
        $newTitle = 'Edited Title';
        $newDescription = "This is an updated description";
        $newDate = today()->format('Y-m-d');
        $newLocation = "New Location";
        $oldParticipants = $entity->participants;
        $newParticipants = array_merge($oldParticipants, [
            'Ms. Nayeon Im',
        ]);

        $this->assertNotEquals($oldParticipants, $newParticipants);

        $res = $this->putJson(route('holiday-plans.update', ['holidayplan' => $entity->id]), [
            'title' => $newTitle,
            'description' => $newDescription,
            'date' => $newDate,
            'location' => $newLocation,
            'participants' => $newParticipants,
        ]);

        $res->assertStatus(200);
        $res->assertJson(
            fn (AssertableJson $json) =>
            $json->has('data')
            ->where('data.title', $newTitle)
                ->where('data.participants', $newParticipants)
                ->etc()
        );
    }

    public function test_user_updates_holiday_plan_of_another_user_fails()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        
        $anotherUser = User::factory()->create();
        $entityOfAnotherUser = HolidayPlan::factory()->user($anotherUser)->create();

        $newTitle = 'Edited Title';
        $newDescription = "This is an updated description";
        $newDate = today()->format('Y-m-d');
        $newLocation = "New Location";
        $newParticipants = [
            'Ms. Nayeon Im',
        ];

        $res = $this->putJson(route('holiday-plans.update', ['holidayplan' => $entityOfAnotherUser->id]), [
            'title' => $newTitle,
            'description' => $newDescription,
            'date' => $newDate,
            'location' => $newLocation,
            'participants' => $newParticipants,
        ]);

        $res->assertStatus(401);
    }

}
