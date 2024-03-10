<?php

namespace Database\Seeders;

use App\Models\HolidayPlan;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class InitialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mainUser = $this->createMainUser();

        $this->createUsers();

        $this->createHolidayPlans(10, $mainUser);

        $this->createHolidayPlans(55);
    }

    private function createMainUser()
    {
        $user = User::factory()->create([
            'name' => 'Sample User',
            'email' => 'user@sample.com',
        ]);


        return $user;
    }

    private function createUsers()
    {
        User::factory()->count(55)->create();
    }

    private function createHolidayPlans($count = 1, $user = null)
    {
        if ($user) {
            HolidayPlan::factory()->user($user)->count($count)->create();    
            return;
        }
        
        HolidayPlan::factory()->count($count)->create();
    }

}
