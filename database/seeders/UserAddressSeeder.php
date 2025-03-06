<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Address;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;

class UserAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userCount = (int) $this->command->ask('How many users do you want to seed?', 10);
        $addressesPerUser = (int) $this->command->ask('How many addresses per user?', 3);

        DB::transaction(function () use ($userCount, $addressesPerUser) {
            User::factory($userCount)->create()->each(function ($user) use ($addressesPerUser) {
                Address::factory($addressesPerUser)->create(['user_id' => $user->id]);
            });
        });
    }
}
