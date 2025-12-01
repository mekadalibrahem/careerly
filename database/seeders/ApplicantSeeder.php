<?php

namespace Database\Seeders;

use App\Models\Work;
use App\Models\User;
use App\Models\Applicant;
use App\Modules\Users\Enums\UserRolesEnums;
use Illuminate\Database\Seeder;

class ApplicantSeeder extends Seeder
{
    public function run(): void
    {
        // Get all Jobs
        $works = Work::all();
        // Get all Candidates
        $candidates = User::where('role', UserRolesEnums::USER)->get();

        if ($candidates->count() < 15) {
            $this->command->error("Not enough candidates. Run CandidateSeeder first.");
            return;
        }

        foreach ($works as $work) {
            // Requirement: "each work should have more then 10 applicants"
            // We pick between 12 and 25 applicants per job
            $numberOfApplicants = rand(12, 25);

            // Pick random users from the candidate pool
            $randomCandidates = $candidates->random($numberOfApplicants);

            foreach ($randomCandidates as $candidate) {

                // Check uniqueness (Safety check)
                $exists = Applicant::where('work_id', $work->id)
                    ->where('user_id', $candidate->id)
                    ->exists();

                if (!$exists) {
                    Applicant::create([
                        'work_id' => $work->id,
                        'user_id' => $candidate->id,
                        // Requirement: "rate profile from 1,100"
                        'ai_rate' => rand(10, 99) + (rand(0, 9) / 10), // e.g. 85.4
                        'accepted' => rand(0, 100) > 90, // Only 10% accepted
                    ]);
                }
            }
        }
    }
}
