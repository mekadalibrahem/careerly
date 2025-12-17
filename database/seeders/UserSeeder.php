<?php

namespace Database\Seeders;

use App\Models\User;
use App\Modules\Users\Enums\UserRolesEnums;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'admin user',
            'email' => 'admin@gmail.local',
            'title' => "site admin"
        ]);
        $user->assignRole(UserRolesEnums::SUPER_ADMIN());
        $user->assignRole(UserRolesEnums::ADMIN());
    }
}
