<?php

namespace Database\Seeders;

use App\Models\User;
use App\Modules\Users\Enums\UserRolesEnums;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'admin user',
            'email' => 'admin@gmail.local',
            'role' => UserRolesEnums::ADMIN,
            'title' => "site admin"
        ]);
    }
}
