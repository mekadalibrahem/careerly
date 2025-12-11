<?php

namespace App\Jobs;

use App\Events\RateApplicantProcessed;

use App\Modules\N8n\Entities\WorkflowCall;

use App\Modules\N8n\WorkflowManager;
use App\Modules\N8n\Workflows\RateApplicantWorkflow;
use App\Modules\Qualifications\QualificationsHelper;
use App\Modules\Works\Entities\Models\Work;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Str;
use InvalidArgumentException;


class RateProcess implements ShouldQueue
{
    use Queueable;
    public $workId;
    /**
     * Create a new job instance.
     */
    public function __construct($workId, public $applicants_ids)
    {
        $this->workId = $workId;
    }

    /**
     * Execute the job.
     */
    public function handle(WorkflowManager $manager): void
    {
        try {
            /** ---------------------------------------------
             *  STEP 1 — Fetch Work with Relations
             * --------------------------------------------*/
            $work = Work::with(['workRequirements', 'applicants'])
                ->find($this->workId);

            if (!$work) {
                logger()->error("Work not found: {$this->workId}");
                throw new InvalidArgumentException("Work not found");
            }

            /** ---------------------------------------------
             *  STEP 2 — Prepare Applicants
             * --------------------------------------------*/
            $applicants = $work->applicants;
            $filteredIds = [];
            // If specific applicant IDs are provided, filter by user_id
            if (!is_null($this->applicants_ids) && is_array($this->applicants_ids)) {
                // Ensure all IDs are integers (optional safety)
                $filteredIds = array_filter($this->applicants_ids, fn($id) => is_numeric($id) && $id > 0);
                if (empty($filteredIds)) {
                    $applicants = collect();
                } else {
                    $applicants = $applicants->only($filteredIds);
                }
            }
            $applicants = $applicants->map(function ($app) {
                return [
                    "user_id"        => $app->user_id,
                    "work_id"        => $app->work_id,
                    "qualifications" => QualificationsHelper::preperForAi($app->id),
                ];
            })->toArray();

            if (empty($applicants)) {
                event(new RateApplicantProcessed($work->id, "No applicants found"));
                throw new InvalidArgumentException("No applicants for work ID {$this->workId}");
            }



            /** ---------------------------------------------
             *  STEP 3 — Chunk Applicants
             * --------------------------------------------*/
            $chunks     = array_chunk($applicants, 5);
            $totalPages = count($chunks);

            /** ---------------------------------------------
             *  STEP 4 — Build Work Base Payload
             * --------------------------------------------*/
            $workflowUuid = (string) Str::orderedUuid();
            $workPayload = [
                "workflow_uuid" => $workflowUuid,
                "id"               => $work->id,
                "name"             => $work->name,
                "description"      => $work->description,
                "work_requirements" => $work->workRequirements->map(fn($req) => [
                    "name"  => $req->name,
                    "level" => $req->level,
                    "type"  => $req->type ?? null,   // optional if new approach requires type
                ])->toArray(),
            ];

            /** ---------------------------------------------
             *  STEP 5 — Trigger Workflow per Chunk
             * --------------------------------------------*/
            foreach ($chunks as $i => $chunk) {
                $payload = [
                    ...$workPayload,
                    "page"        => $i + 1,
                    "total_pages" => $totalPages,
                    "applicants"  => $chunk,
                ];
                WorkflowCall::create([
                    'workflow_id' => $workflowUuid,
                    'type' => RateApplicantWorkflow::class,
                    'total_chunks' => $totalPages,
                    'chunk_number' => $i + 1,
                    'payload' => $payload,
                    'user_id' => $work->user_id,
                ]);

                $manager->run("rateApplicants", $payload);
            }

            logger()->info("RateProcess Job Completed Successfully for Work ID: {$this->workId}");
        } catch (\Throwable $th) {
            logger()->error("RateProcess Error: " . $th->getMessage());
        }
    }
}
