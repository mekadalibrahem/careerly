<?php

namespace App\Modules\N8n\Enums;

use App\Utils\EnumHelperTraits\CasesCounts;
use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Names;
use ArchTech\Enums\Values;

enum WorkflowStatusEnum: string
{
    use InvokableCases;
    use Names;
    use Values;
    use CasesCounts;
    
    case RUNNING = "running";
    case END = "end";
    case TIMEOUT = "timeout";
}
