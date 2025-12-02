<?php

namespace Database\Seeders;

use App\Modules\Qualifications\Entities\Models\Education;
use Illuminate\Database\Seeder;

class EducationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Education::create([
            "user_id" => 3,
            "name" =>  "B.Sc. Computer Science",
            "degree" =>  "Bachelor",
            "institution" => "University of Amsterdam",
            "grade" => 85,
            "start_at" => "2018-10-29 18:26:50",
            "end_at" => "2023-10-29 18:26:50",
        ]);
    }
}
