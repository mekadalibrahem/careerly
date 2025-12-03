<?php

namespace App\Modules\Works\Enums;

use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Names;
use ArchTech\Enums\Values;

enum WorkTypesEnum: string
{
    use InvokableCases;
    use Names;
    use Values;

    case FULLTIME = "full-time";
    case PARTTIME = "part-time";
    case CONTRACT = "contract";
    case INTERNSHIP = "internship";
}
