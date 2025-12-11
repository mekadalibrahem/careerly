<?php

namespace Database\Seeders;


use App\Models\User;

use App\Modules\Users\Enums\UserRolesEnums;
use App\Modules\Works\Entities\Models\Applicant;
use App\Modules\Works\Entities\Models\Work;
use Illuminate\Database\Seeder;

class ApplicantSeeder extends Seeder
{
    public function run(): void
    {
        // Get all Jobs
        $works = Work::all();
        // Get all Candidates
        $candidates = User::where('role', UserRolesEnums::JOBSEEKER())->get();

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
                       
                        // 'accepted' => rand(0, 100) > 90, // Only 10% accepted
                    ]);
                }
            }
        }
    }
}
