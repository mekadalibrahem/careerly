<?php 

namespace App\Modules\Admin\Services\Traits\Stats;

use App\Modules\N8n\Entities\WorkflowCall;
use App\Modules\N8n\Enums\AiAnalyzeTypeEnum;
use App\Modules\N8n\Enums\WorkflowStatusEnum;
use Illuminate\Support\Facades\DB;

trait HasAIStatus {

    public static function AIRequestcountByStatus(){
        $counts = WorkflowCall::select('status', DB::raw("count(*) as total"))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();
       
        return WorkflowStatusEnum::casesCount($counts);
    }
    public static function AIRequestcountByType(){
        $counts = WorkflowCall::select('type', DB::raw("count(*) as total"))
            ->groupBy('type')
            ->pluck('total', 'type')
            ->toArray();
       
        return AiAnalyzeTypeEnum::casesCount($counts);
    }
    
}
