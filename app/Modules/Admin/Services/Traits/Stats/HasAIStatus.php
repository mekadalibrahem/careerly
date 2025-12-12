<?php 

namespace App\Modules\Admin\Services\Traits\Stats;

use App\Modules\N8n\Entities\WorkflowCall;
use App\Modules\N8n\Enums\WorkflowStatusEnum;
use Illuminate\Support\Facades\DB;

trait HasAIStatus {

    public static function AIRequestcountByStatus(){
        $count = WorkflowCall::select('status', DB::raw("count(*) as total"))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();
        $allStatuses = array_fill_keys(
            WorkflowStatusEnum::values(), 
            0
        );
        return array_merge($allStatuses, $count);
    }
    
}
