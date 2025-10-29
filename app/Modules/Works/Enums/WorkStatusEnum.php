<?php

namespace App\Modules\Works\Enums;

use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Names;
use ArchTech\Enums\Values;

enum WorkStatusEnum: string
{
    use Names;
    use Values;
    use InvokableCases;

    case END = "end";
    case RUNNING = "running";
}
