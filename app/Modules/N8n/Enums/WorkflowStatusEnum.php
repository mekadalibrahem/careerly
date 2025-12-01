<?php

namespace App\Modules\N8n\Enums;

use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Names;
use ArchTech\Enums\Values;

enum WorkflowStatusEnum: string
{
    use InvokableCases;
    use Names;
    use Values;
    case RUNNING = "running";
    case END = "end";
    case TIMEOUT = "timeout";
}
