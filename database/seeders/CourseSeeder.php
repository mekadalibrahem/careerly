<?php

namespace Database\Seeders;

use App\Modules\Qualifications\Entities\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Course::create([
            "user_id" => 3,
            "name" =>  "Machine Learning",
            "provider" =>  "Coursera",
            "duration" => "3 mounth",
            "url" => "https://url-link",
        ]);
    }
}
