<?php

namespace Database\Seeders;

use App\Models\User;

use App\Modules\Users\Enums\UserRolesEnums;
use App\Modules\Works\Entities\Models\Work;
use App\Modules\Works\Entities\Models\WorkRequirement;
use App\Modules\Works\Enums\WorkStatusEnum;
use App\Modules\Works\Enums\WorkTypesEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class HRWorkSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('password');
        $status = WorkStatusEnum::values(); // active,colsed
        $types = WorkTypesEnum::values(); //  full-time, part-time, contract, internship
        // DATASET: Real Jobs with Matching Requirements
        $jobTemplates = [
            [
                'name' => 'Senior Backend Developer (PHP)',
                'desc' => 'We are looking for an experienced Laravel developer to handle our payment infrastructure.',
                'reqs' => [
                    ['name' => 'Framework', 'desc' => 'Expert knowledge of Laravel', 'level' => 'Senior'],
                    ['name' => 'Database', 'desc' => 'MySQL optimization experience', 'level' => 'Mid-Senior'],
                ],
                'company' => "Company A",
                'location' => "Syria - Address 1",
                'requirements_txt' => "Strong Laravel background, database optimization.",
                'benefits_txt' => "Health insurance, remote work options",
            ],
            [
                'name' => 'Lead Data Scientist',
                'desc' => 'Join our AI team to build predictive models for the fintech sector.',
                'reqs' => [
                    ['name' => 'Python', 'desc' => 'Pandas and NumPy proficiency', 'level' => 'Expert'],
                    ['name' => 'ML', 'desc' => 'Experience with Neural Networks', 'level' => 'Senior'],
                ],
                'company' => "Company B",
                'location' => "Jordan - Amman",
                'requirements_txt' => "Proficiency in ML, Python, and data processing.",
                'benefits_txt' => "Competitive salary, bonuses",
            ],
            [
                'name' => 'Frontend Architect',
                'desc' => 'Design the design system for our new global SaaS product.',
                'reqs' => [
                    ['name' => 'JS', 'desc' => 'Deep understanding of React & DOM', 'level' => 'Senior'],
                    ['name' => 'CSS', 'desc' => 'TailwindCSS Architecture', 'level' => 'Expert'],
                ],
                'company' => "Company C",
                'location' => "UAE - Dubai",
                'requirements_txt' => "Strong React and UI architecture experience.",
                'benefits_txt' => "Housing allowance, travel tickets",
            ],
            [
                'name' => 'DevOps Specialist',
                'desc' => 'Manage our AWS infrastructure and CI/CD pipelines.',
                'reqs' => [
                    ['name' => 'Cloud', 'desc' => 'AWS Certification', 'level' => 'Professional'],
                    ['name' => 'Containerization', 'desc' => 'Docker & K8s', 'level' => 'Senior'],
                ],
                'company' => "Company D",
                'location' => "Remote",
                'requirements_txt' => "AWS, CI/CD pipelines, Docker, Kubernetes.",
                'benefits_txt' => "Fully remote, equipment budget",
            ]
        ];


        // GENERATE 25 HR USERS
        for ($i = 1; $i <= 25; $i++) {

            // 1. Create HR
            $hr = User::create([
                'name' => fake()->name(),
                'email' => "hr_{$i}@gmail.local",
                'title' => 'Talent Acquisition Manager',
                "bio" => 'Talent Acquisition Manager',
                "phone" => fake()->phoneNumber(),
                'password' => $password,
                'email_verified_at' => now(),
            ]);
            $hr->assignRole(UserRolesEnums::RECRUITER());
            // 2. Create Works (Jobs) for this HR
            // Each HR posts between 2 and 5 jobs
            $numberOfJobs = rand(2, 5);

            for ($j = 0; $j < $numberOfJobs; $j++) {
                $template = $jobTemplates[array_rand($jobTemplates)];

                $work = Work::create([
                    'user_id' => $hr->id,
                    'name' => $template['name'],
                    'description' => $template['desc'] . " Position based in Amsterdam or Remote.",
                    'company' => fake()->company(),
                    'location' => $template['location'],
                    'type' => $types[array_rand($types)],
                    'salary_range' => rand(800, 6000) . "$ - " . rand(6001, 12000) . "$",
                    'requirements' => $template['requirements_txt'],
                    'benefits' => $template['benefits_txt'],
                    'status' => WorkStatusEnum::ACTIVE(),
                ]);


                // Requirements Table Seeder
                foreach ($template['reqs'] as $req) {
                    WorkRequirement::create([
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
