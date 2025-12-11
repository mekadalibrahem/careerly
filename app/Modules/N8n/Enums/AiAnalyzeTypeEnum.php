<?php

namespace App\Modules\N8n\Enums;

use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Names;
use ArchTech\Enums\Values;

enum AiAnalyzeTypeEnum: string
{
    use InvokableCases;
    use Names;
    use Values;

    case CV = "cv-analyze";
    case APPLICANT = "applicant-analyze";
}
