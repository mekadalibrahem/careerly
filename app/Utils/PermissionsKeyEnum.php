<?php

namespace App\Utils;


use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Names;
use ArchTech\Enums\Values;

enum PermissionsKeyEnum : string
{
    use InvokableCases;
    use Values;
    use Names;

    /**
     * Admin permissions
     */
    case MANAGE_ADMINS = "manage-admins";
    case MANAGE_USER = "manage-users";
    case MANAGE_ROLES = "manage-roles";
    case VIEW_STATS  = "view-stats";
    case MANAGE_JOB = "manage-job";

    /**
     * Basic User Permissions
     */
    case  VIEW_PUBLIC_CONTENT =  "view-public-content";

    /**
     * Hr Permissions
     */

    case CREATE_JOBS = "create-jobs";
    case VIEW_APPLICATIONS = "view-applications";
    case MANAGE_OWN_JOBS = "manage-own-jobs";
    /**
     * Job seeker Permissions
     */

    case VIEW_JOBS = "view-jobs";
    case APPLY_TO_JOB = "apply-to-job";
    case MANAGE_PROFILE = "manage-profile";

}
