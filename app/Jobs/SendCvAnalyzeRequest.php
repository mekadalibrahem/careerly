<?php

namespace App\Jobs;

use App\Models\User;
use App\Modules\N8n\WorkflowManager;
use App\Modules\Qualifications\QualificationsHelper;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Str;
use App\Modules\N8n\Entities\WorkflowCall;
use App\Modules\N8n\Enums\AiAnalyzeTypeEnum;
use App\Modules\N8n\Workflows\AnalyzeCvWorkflow;

class SendCvAnalyzeRequest implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public User $user)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(WorkflowManager $manager): void
    {
        try {
            $user = $this->user;
            $workflowUuid = (string) Str::orderedUuid();
            $payload = [
                "workflow_uuid" => $workflowUuid,
                "page"        =>  1,
                "total_pages" => 1,
                "user_id" => $user->id,
                "data" => QualificationsHelper::preperForAi($user->id)
            ];

            WorkflowCall::create([
                'workflow_id' => $workflowUuid,
                'type' => AiAnalyzeTypeEnum::CV(),
                'total_chunks' => 1,
                'chunk_number' => 1,
                'payload' => $payload,
                'user_id' => $user->id,
            ]);
            $manager->run(AiAnalyzeTypeEnum::CV(), $payload);
            logger()->info(__CLASS__ . " - DONE");
        } catch (\Throwable $th) {
            logger()->error(__CLASS__ . " - FAILD JOB" .  $th->getMessage());
        }
    }
}
