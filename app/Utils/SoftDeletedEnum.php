<?php
namespace  App\Utils;

use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Names;
use ArchTech\Enums\Values;

enum SoftDeletedEnum : string {
    use Values;
    use InvokableCases;
    use Names;
    case WITH_DELETED = "with-deleted";
    case DELETED_ONLY = "deleted-only";
}
