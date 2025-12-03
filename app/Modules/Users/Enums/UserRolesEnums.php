<?php

namespace App\Modules\Users\Enums;

use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Names;
use ArchTech\Enums\Values;

enum UserRolesEnums: string
{
    use InvokableCases;
    use Names;
    use Values;

    case ADMIN = 'admin';
    case USER = 'user';
    case RECRUITER = 'recruiter';
    case JOBSEEKER = "job_seeker";
}
