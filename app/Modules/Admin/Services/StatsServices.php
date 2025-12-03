<?php

namespace App\Modules\Admin\Services;

use App\Models\User;
use App\Modules\Admin\Services\Traits\Stats\HasJobStats;
use App\Modules\Admin\Services\Traits\Stats\HasUserStats;

class StatsServices
{

    use HasUserStats;
    use HasJobStats;
}
