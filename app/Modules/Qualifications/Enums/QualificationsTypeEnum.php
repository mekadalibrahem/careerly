<?php

namespace App\Modules\Qualifications\Enums;

use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Names;
use ArchTech\Enums\Options;
use ArchTech\Enums\Values;

enum QualificationsTypeEnum: string
{
    use Names;
    use Values;
    use InvokableCases;
    use Options;

    case SKILL  = 'skill';
    case EDUCATION = "education";
    case COURSE = "course";
    case PROJECT = "project";
}
