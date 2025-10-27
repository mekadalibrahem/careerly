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
            'email' => 'admin@example.com',
            'role' => UserRolesEnums::admin(),
            'title' => "site admin"
        ]);
        User::factory()->create([
            'name' => 'hr user',
            'email' => 'hr@example.com',
            'role' => UserRolesEnums::hr(),
            'title' => "HR"
        ]);
        User::factory()->create([
            'name' => 'ahmad sami',
            'email' => 'user01@example.com',
            'role' => UserRolesEnums::user(),
            'title' => "Backend Developer"
        ]);
    }
}
