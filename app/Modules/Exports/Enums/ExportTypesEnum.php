<?php
namespace  App\Modules\Exports\Enums;

use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Names;
use ArchTech\Enums\Values;

enum ExportTypesEnum : string
{
    use InvokableCases;
    use Values;
    use Names;

    case CV = "cv-file";

}

