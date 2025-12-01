<?php

namespace App\Modules\Works;


class WorkHelper
{

    public static function preperForAi($work_id = 0)
    {
        // static data for testing agent only
        // TODO: implement method to preperData for ai
        return [
            "id" => 14,
            "name" => "Full Stack Developer",
            "description" => "We need Laravel + Vue developer...",
            "page" => 1,
            "total_page" => 1,
            "work_requirements" => [
                ["name" => "Laravel", "level" => "advanced"],
                ["name" => "Vue", "level" => "intermediate"],
                ["name" => "SQL", "level" => "advanced"]
            ],
            "applicants" => [
                [
                    "user_id" => 1,
                    "work_id" => 14,
                    "qualifications" => [
                        "skills" => [
                            ["name" => "Laravel"],
                            ["name" => "SQL"],
                            ["name" => "Vue"]
                        ],
                        "projects" => [],
                        "courses" => [],
                        "educations" => []
                    ]
                ],
                [
                    "user_id" => 2,
                    "work_id" => 14,
                    "qualifications" => [
                        "skills" => [
                            ["name" => "Laravel"]
                        ],
                        "projects" => [],
                        "courses" => [],
                        "educations" => []
                    ]
                ],
                [
                    "user_id" => 3,
                    "work_id" => 14,
                    "qualifications" => [
                        "skills" => [
                            ["name" => "Vue"],
                            ["name" => "SQL"]
                        ],
                        "projects" => [],
                        "courses" => [],
                        "educations" => []
                    ]
                ],
                [
                    "user_id" => 4,
                    "work_id" => 14,
                    "qualifications" => [
                        "skills" => [
                            ["name" => "React"],
                            ["name" => "NodeJS"]
                        ],
                        "projects" => [],
                        "courses" => [],
                        "educations" => []
                    ]
                ],
                [
                    "user_id" => 5,
                    "work_id" => 14,
                    "qualifications" => [
                        "skills" => [
                            ["name" => "Laravel"],
                            ["name" => "SQL"]
                        ],
                        "projects" => [],
                        "courses" => [],
                        "educations" => []
                    ]
                ],
                [
                    "user_id" => 6,
                    "work_id" => 14,
                    "qualifications" => [
                        "skills" => [
                            ["name" => "Laravel"],
                            ["name" => "Vue"],
                            ["name" => "SQL"],
                            ["name" => "Tailwind"]
                        ],
                        "projects" => [],
                        "courses" => [],
                        "educations" => []
                    ]
                ]
            ]
        ];
    }
}
