<?php

namespace Database\Seeders;

use App\Models\User;
use App\Modules\Qualifications\Entities\Models\Course;
use App\Modules\Qualifications\Entities\Models\Education;
use App\Modules\Qualifications\Entities\Models\Project;
use App\Modules\Qualifications\Entities\Models\Skill;
use App\Modules\Users\Enums\UserRolesEnums;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CandidateSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('password');

        // THE DATASET: Coherent Profiles
        $specializations = [
            'backend' => [
                'titles' => ['Senior Backend Engineer', 'PHP Developer', 'Laravel Specialist', 'API Architect'],
                'skills' => ['PHP', 'Laravel', 'MySQL', 'Redis', 'ElasticSearch', 'Clean Architecture', 'Unit Testing'],
                'projects' => [
                    ['name' => 'High-Load API Gateway', 'tools' => 'Laravel, Redis, Lua', 'desc' => 'Orchestrated a gateway handling 10k requests/sec.'],
                    ['name' => 'SaaS Billing System', 'tools' => 'PHP, Stripe API, MySQL', 'desc' => 'Built subscription engine with invoicing and tax calculation.'],
                    ['name' => 'Microservices Migration', 'tools' => 'Lumen, Docker, Kafka', 'desc' => 'Migrated monolith legacy app to distributed microservices.'],
                ],
                'degrees' => ['B.Sc. Computer Science', 'B.Eng Software Engineering']
            ],
            'frontend' => [
                'titles' => ['Frontend Developer', 'React Engineer', 'UI/UX Implementer', 'Vue.js Expert'],
                'skills' => ['Javascript', 'React', 'Vue.js', 'TailwindCSS', 'Figma', 'TypeScript', 'Next.js'],
                'projects' => [
                    ['name' => 'E-commerce Dashboard', 'tools' => 'Vue.js, Vuex, Chart.js', 'desc' => 'Responsive admin panel for tracking sales and inventory.'],
                    ['name' => 'Social Media UI', 'tools' => 'React, Redux, Tailwind', 'desc' => 'Pixel perfect clone of a major social network feed.'],
                    ['name' => '3D Product Configurator', 'tools' => 'Three.js, WebGL, React', 'desc' => 'Interactive 3D model viewer for automotive customization.'],
                ],
                'degrees' => ['B.A. Interaction Design', 'B.Sc. Multimedia Computing']
            ],
            'data' => [
                'titles' => ['Data Scientist', 'Machine Learning Engineer', 'Data Analyst', 'AI Researcher'],
                'skills' => ['Python', 'Pandas', 'PyTorch', 'TensorFlow', 'SQL', 'Tableau', 'BigQuery'],
                'projects' => [
                    ['name' => 'Customer Churn Predictor', 'tools' => 'Python, Scikit-Learn', 'desc' => 'ML model predicting user unsubscription rates with 90% accuracy.'],
                    ['name' => 'Computer Vision Security', 'tools' => 'OpenCV, YOLO, Python', 'desc' => 'Real-time object detection system for security feeds.'],
                    ['name' => 'Stock Market LSTM', 'tools' => 'TensorFlow, Keras', 'desc' => 'Time-series forecasting for high-frequency trading.'],
                ],
                'degrees' => ['M.Sc. Data Science', 'Ph.D. Statistics']
            ],
            'devops' => [
                'titles' => ['DevOps Engineer', 'Cloud Architect', 'SRE', 'System Administrator'],
                'skills' => ['AWS', 'Docker', 'Kubernetes', 'Terraform', 'Jenkins', 'Linux', 'Bash'],
                'projects' => [
                    ['name' => 'Kubernetes Cluster Setup', 'tools' => 'K8s, Helm, Azure', 'desc' => 'Self-healing cluster setup for high availability applications.'],
                    ['name' => 'CI/CD Pipeline Automation', 'tools' => 'Jenkins, Groovy, Git', 'desc' => 'Zero-downtime deployment pipeline for 50+ microservices.'],
                ],
                'degrees' => ['B.Sc. Network Engineering', 'B.Sc. Information Systems']
            ],
            'mobile' => [
                'titles' => ['iOS Developer', 'Android Developer', 'Flutter Engineer', 'React Native Dev'],
                'skills' => ['Swift', 'Kotlin', 'Flutter', 'Dart', 'Firebase', 'SQLite'],
                'projects' => [
                    ['name' => 'Fitness Tracking App', 'tools' => 'Flutter, Firebase', 'desc' => 'Cross-platform app tracking GPS and heart rate data.'],
                    ['name' => 'Banking Mobile App', 'tools' => 'Swift, CoreData', 'desc' => 'Secure native iOS application for banking transactions.'],
                ],
                'degrees' => ['B.Sc. Mobile Computing', 'B.Sc. Computer Science']
            ],
        ];

        $universities = ['MIT', 'Stanford', 'University of Amsterdam', 'TU Berlin', 'Oxford', 'ETH Zurich'];

        // GENERATE 100 USERS
        for ($i = 1; $i <= 100; $i++) {

            // 1. Pick a random career path for this specific user
            $pathKey = array_rand($specializations);
            $pathData = $specializations[$pathKey];

            // 2. Create User
            $user = User::create([
                'name' => fake()->name(),
                'email' => "user_{$i}@gmail.local",
                'role' => UserRolesEnums::JOBSEEKER(),
                'title' => $pathData['titles'][array_rand($pathData['titles'])], // Pick a relevant title
                'password' => $password,
                'email_verified_at' => now(),
            ]);

            // 3. Add Related Skills (3 to 5 skills)
            $userSkills = collect($pathData['skills'])->random(rand(3, count($pathData['skills'])));
            foreach ($userSkills as $skillName) {
                Skill::create(['user_id' => $user->id, 'name' => $skillName]);
            }

            // 4. Add Related Project (1 or 2)
            $userProjects = collect($pathData['projects'])->random(rand(1, count($pathData['projects'])));
            foreach ($userProjects as $proj) {
                Project::create([
                    'user_id' => $user->id,
                    'name' => $proj['name'],
                    'description' => $proj['desc'],
                    'tools' => $proj['tools'],
                    'url' => 'https://github.com/example/repo',
                ]);
            }

            // 5. Education
            Education::create([
                'user_id' => $user->id,
                'name' => $pathData['degrees'][array_rand($pathData['degrees'])],
                'institution' => $universities[array_rand($universities)],
                'degree' => 'Bachelor',
                'grade' => rand(75, 98) . '%',
                'start_at' => now()->subYears(rand(3, 10)),
                'end_at' => now()->subYears(rand(1, 3)),
            ]);

            // 6. Course (Generic but useful)
            Course::create([
                'user_id' => $user->id,
                'name' => 'Advanced ' . ucfirst($pathKey) . ' Patterns',
                'provider' => 'Udemy',
                'duration' => '40 Hours',
                'url' => 'https://udemy.com/cert',
            ]);
        }
    }
}
