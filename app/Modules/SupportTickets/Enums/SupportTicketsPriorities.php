<?php
namespace App\Modules\SupportTickets\Enums;

use App\Utils\EnumHelperTraits\CasesCounts;
use App\Utils\EnumHelperTraits\ValidationEnumValue;
use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Names;
use ArchTech\Enums\Values;

enum SupportTicketsPriorities: string
{
    use InvokableCases;
    use Values;
    use Names;
    use ValidationEnumValue;
    use CasesCounts;

    case LOW = "low";
    case MEDIUM = "medium";
    case HIGH = "high";
}

