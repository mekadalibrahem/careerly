<?php

namespace App\Modules\Exports\Enums;

use App\Utils\EnumHelperTraits\ValidationEnumValue;
use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Names;
use ArchTech\Enums\Values;

enum CvStyleTypesEnum : string
{
    use InvokableCases;
    use Values;
    use Names;
    use ValidationEnumValue;

    case CLASSIC = "classic";
}
