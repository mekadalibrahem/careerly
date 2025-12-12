<?php

namespace App\Jobs;

use App\Events\RateApplicantProcessed;
use App\Modules\N8n\Entities\Repositories\WorkflowCallRepository;
use App\Modules\N8n\Entities\WorkflowCall;
use App\Modules\N8n\Enums\AiAnalyzeTypeEnum;
use App\Modules\N8n\Enums\WorkflowStatusEnum;
use App\Notifications\FaildCvAnalyze;
use App\Notifications\FaildRateApplicant;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;

class ClearWorkflowCallsAsTimeout implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            logger()->info("clear workflow start");
            // step 1 get all workflow that not end and take more then 1 day
            $workflows = WorkflowCall::where("status", WorkflowStatusEnum::RUNNING())
                ->whereDate('created_at', '<', now()->subDay())
                ->with('user')
                ->get();
            $workflowsRepo = new WorkflowCallRepository();
            foreach ($workflows as $item) {
                $workflowsRepo->markFailed($item->id, "TIME OUT AFTER DAY WITHOUT RESPONSE RESULT");

                logger()->info("ITEM WORKFLOW ID $item->id AND is Full Completed is : " . $workflowsRepo->isFullyCompleted($item->workflow_id));

                if ($workflowsRepo->isFullyCompleted($item->workflow_id)) {
                    switch ($item->type) {
                        case AiAnalyzeTypeEnum::CV():
                            $item->user->notify(new FaildCvAnalyze());
                            break;
                        case AiAnalyzeTypeEnum::APPLICANT():

                            $payload = json_decode($item->payload);
                            $work_id = $payload['work_id'];
                            $item->user->notify(new FaildRateApplicant($work_id));
                            break;
                        default:
                            # code...
                            break;
                    }
                }
            }
            logger()->info("clear workflow end with timeout count " . $workflows->count());
        } catch (\Throwable $th) {
            logger()->error(__CLASS__ . "ERROR :" . $th->getMessage());
            //throw $th;
        }
    }
}
