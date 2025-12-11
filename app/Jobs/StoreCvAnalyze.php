<?php

namespace App\Jobs;

use App\Events\CvAnalyzeProcessed;
use App\Models\User;
use App\Modules\N8n\Entities\AiAnalyze;
use App\Modules\N8n\Entities\Repositories\WorkflowCallRepository;
use App\Modules\N8n\Enums\AiAnalyzeTypeEnum;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use InvalidArgumentException;

class StoreCvAnalyze implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public ?array $data)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $workflow_id = $this->data['workflow_uuid'];
            $page_number = $this->data['page'];
            $user_id     = $this->data['user_id'];
            $result     = $this->data['results'];

            // 1. Get/Validate page
            $repo = new WorkflowCallRepository();
            $page = $repo->getPage($workflow_id, $page_number);

            if (!$page) {
                throw new InvalidArgumentException("PAGE NOT FOUND");
            }
            AiAnalyze::upsert(
                [
                    'data' => json_encode($result),
                    'type' => AiAnalyzeTypeEnum::CV(),
                    "analyze_id" => $user_id,
                    "analyze_type" =>  User::class,
                ],
                ['analyze_id', 'analyze_type', 'type'],
                ['data']
            );


            // 4. Mark page completed
            $repo->markCompleted($page->id, $this->data);

            // 5. Check if workflow fully completed and dispatch event
            if ($repo->isFullyCompleted($workflow_id)) {
                event(new CvAnalyzeProcessed($user_id));
            }
        } catch (\Throwable $th) {
            logger()->error("Store ai analyze ERROR", [$th]);
            throw $th;
        }
    }
}
