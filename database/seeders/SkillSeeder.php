<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Skill::create([
            "user_id" => 3,
            "name" =>  "Programming",
        ]);
        Skill::create([
            "user_id" => 3,
            "name" =>  "Data Analysis",
        ]);
    }
}
