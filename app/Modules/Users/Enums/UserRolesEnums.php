<?php

namespace App\Modules\Users\Enums;

use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Names;
use ArchTech\Enums\Values;

enum UserRolesEnums
{
    use InvokableCases;
    use Names;
    use Values;
    
    case admin;
    case user;
    case hr;
}
