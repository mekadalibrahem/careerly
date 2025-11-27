<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Project::create([
            "user_id" => 3,
            "name" =>  "Sentiment Analysis Tool",
            "description" =>  "Built NLP model to analyze reviews",
            "tools" => 'Python, NLTK, Scikit-learn',
            "url" => "https://url-link",
        ]);
    }
}
