<?php

namespace App\Modules\N8n\Enums;

use App\Utils\EnumHelperTraits\CasesCounts;
use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Names;
use ArchTech\Enums\Values;

enum AiAnalyzeTypeEnum: string
{
    use InvokableCases;
    use Names;
    use Values;
    use CasesCounts;
    
    case CV = "cv-analyze";
    case APPLICANT = "applicant-analyze";
}
