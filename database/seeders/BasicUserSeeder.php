<?php

namespace Database\Seeders;

use App\Models\User;
use App\Modules\Users\Enums\UserRolesEnums;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class BasicUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i=1 ;$i<11 ;$i++){
            $user = User::create([
                'name' => fake()->name(),
                'email' => "buser_$i@gmail.local",
                'title' => "basic user",
                "bio" => "basic user bio",
                "password" => Hash::make("password"),
                "email_verified_at" => now()
            ]);
            $user->assignRole(UserRolesEnums::USER());
        }



    }
}
