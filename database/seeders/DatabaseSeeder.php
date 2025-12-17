<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionsSeeder::class,
            UserSeeder::class,
            CandidateSeeder::class,
            HRWorkSeeder::class,
            ApplicantSeeder::class,
            SupportTicketsSeeder::class,
            BasicUserSeeder::class
        ]);
    }
}
