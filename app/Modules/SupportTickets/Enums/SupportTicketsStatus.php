<?php

namespace App\Modules\SupportTickets\Enums;

use App\Utils\EnumHelperTraits\CasesCounts;
use App\Utils\EnumHelperTraits\ValidationEnumValue;
use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Names;
use ArchTech\Enums\Values;

enum SupportTicketsStatus: string
{
    use InvokableCases;
    use Values;
    use Names;
    use ValidationEnumValue;
    use CasesCounts;

    case OPEN = "open";
    case CLOSE = "close";

}

