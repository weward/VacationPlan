<?php

namespace Database\Factories;

use App\Models\User;
use Carbon\Carbon;
use Hamcrest\Type\IsObject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HolidayPlan>
 */
class HolidayPlanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::factory()->create();

        return [
            'title' => fake()->company,
            'description' => fake()->realText(150, 2),
            'date' => today(),
            'location' => fake()->address,
            'participants' => [
                fake()->name,
                fake()->name,
                fake()->name,
                fake()->name,
            ],
            'user_id' => $user->id,
        ];
    }

    /**
     * Indicate the model's date.
     */
    public function date($dateInput): static
    {
        return $this->state(fn (array $attributes) => [
            'date' => Carbon::parse($dateInput)->format('Y-m-d'),
        ]);
    }

    public function user($user): static
    {
        $user = is_object($user) ? $user->id : $user;
        $user = is_array($user) ? $user['id'] : $user;

        return $this->state(fn (array $attributes) => [
            'user_id' => $user,
        ]);
    }
}
