<?php

namespace Database\Seeders;

use App\Models\User;

use App\Modules\Users\Enums\UserRolesEnums;
use App\Modules\Works\Entities\Models\Work;
use App\Modules\Works\Entities\Models\WorkRequirment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class HRWorkSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('password');

        // DATASET: Real Jobs with Matching Requirements
        $jobTemplates = [
            [
                'name' => 'Senior Backend Developer (PHP)',
                'desc' => 'We are looking for an experienced Laravel developer to handle our payment infrastructure.',
                'reqs' => [
                    ['name' => 'Framework', 'desc' => 'Expert knowledge of Laravel', 'level' => 'Senior'],
                    ['name' => 'Database', 'desc' => 'MySQL optimization experience', 'level' => 'Mid-Senior'],
                ]
            ],
            [
                'name' => 'Lead Data Scientist',
                'desc' => 'Join our AI team to build predictive models for the fintech sector.',
                'reqs' => [
                    ['name' => 'Python', 'desc' => 'Pandas and NumPy proficiency', 'level' => 'Expert'],
                    ['name' => 'ML', 'desc' => 'Experience with Neural Networks', 'level' => 'Senior'],
                ]
            ],
            [
                'name' => 'Frontend Architect',
                'desc' => 'Design the design system for our new global SaaS product.',
                'reqs' => [
                    ['name' => 'JS', 'desc' => 'Deep understanding of React & DOM', 'level' => 'Senior'],
                    ['name' => 'CSS', 'desc' => 'TailwindCSS Architecture', 'level' => 'Expert'],
                ]
            ],
            [
                'name' => 'DevOps Specialist',
                'desc' => 'Manage our AWS infrastructure and CI/CD pipelines.',
                'reqs' => [
                    ['name' => 'Cloud', 'desc' => 'AWS Certification', 'level' => 'Professional'],
                    ['name' => 'Containerization', 'desc' => 'Docker & K8s', 'level' => 'Senior'],
                ]
            ]
        ];

        // GENERATE 25 HR USERS
        for ($i = 1; $i <= 25; $i++) {

            // 1. Create HR
            $hr = User::create([
                'name' => fake()->name(),
                'email' => "hr_{$i}@example.com",
                'role' => UserRolesEnums::HR,
                'title' => 'Talent Acquisition Manager',
                'password' => $password,
                'email_verified_at' => now(),
            ]);

            // 2. Create Works (Jobs) for this HR
            // Each HR posts between 2 and 5 jobs
            $numberOfJobs = rand(2, 5);

            for ($j = 0; $j < $numberOfJobs; $j++) {
                $template = $jobTemplates[array_rand($jobTemplates)];

                $work = Work::create([
                    'user_id' => $hr->id,
                    'name' => $template['name'],
                    'description' => $template['desc'] . " Position based in Amsterdam or Remote.",
                    'status' => 'running', // Assuming enum value or string
                ]);

                // 3. Add Requirements
                foreach ($template['reqs'] as $req) {
                    WorkRequirment::create([
                        'work_id' => $work->id,
                        'name' => $req['name'],
                        'description' => $req['desc'],
                        'level' => $req['level'],
                    ]);
                }
            }
        }
    }
}
