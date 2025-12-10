<?php

namespace App\Modules\Works\Enums;

use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Names;
use ArchTech\Enums\Values;

enum ApplicantStatusEnum: string
{
    use Names;
    use Values;
    use InvokableCases;


    case PENDING = "pending";
    case ACCEPTED = "accepted";
    case REJECTED = "rejected";
}
