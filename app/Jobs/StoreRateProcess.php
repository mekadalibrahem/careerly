<?php

namespace App\Jobs;

use App\Events\RateApplicantProcessed;
use App\Modules\N8n\Entities\Repositories\WorkflowCallRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection; // Add this if you don't have it
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class StoreRateProcess implements ShouldQueue
{
    use Queueable;

    public ?array $data;

    public function __construct(?array $data)
    {
        $this->data = $data;
    }

    /**
     * The main job method, now focused on orchestration.
     */
    public function handle(): void
    {


        try {
            $workflow_id = $this->data['workflow_uuid'];
            $page_number = $this->data['page'];
            $work_id     = $this->data['work_id'];
            $results     = $this->data['results'];

            // 1. Get/Validate page
            $repo = new WorkflowCallRepository();
            $page = $repo->getPage($workflow_id, $page_number);

            if (!$page) {
                throw new InvalidArgumentException("PAGE NOT FOUND");
            }

            // 2. Prepare values
            $values = collect($results)->map(function ($item) use ($work_id) {
                return [
                    'work_id'    => $work_id,
                    'user_id'    => $item['user_id'],
                    'ai_rate'    => $item['score'],
                ];
            });

            // 3. Execute the single batch update
            $this->updateApplicantsInBatch($work_id, $values);

            // 4. Mark page completed
            $repo->markCompleted($page->id, $this->data);

            // 5. Check if workflow fully completed and dispatch event
            if ($repo->isFullyCompleted($workflow_id)) {
                event(new RateApplicantProcessed($work_id));
            }
        } catch (\Throwable $th) {
            Log::error("Store ai rate ERROR", [$th]);
            throw $th;
        }
    }

    // --- Private Helper Method for Batch Update ---

    /**
     * Executes a single, optimized batch update query using a CASE statement.
     *
     * @param int $workId The ID of the work (job) being processed.
     * @param \Illuminate\Support\Collection $values The data to update.
     */
    private function updateApplicantsInBatch(int $workId, \Illuminate\Support\Collection $values): void
    {
        if ($values->isEmpty()) {
            return;
        }

        $ids = $values->pluck('user_id')->toArray();
        $caseStatements = [];
        $bindings = [];
        $updatedAt = now()->toDateTimeString();

        // Build the CASE statement for ai_rate
        foreach ($values as $item) {
            $caseStatements[] = "WHEN user_id = ? THEN ?";
            $bindings[] = $item['user_id'];
            $bindings[] = (float) $item['ai_rate'];
        }

        $caseSql = implode(' ', $caseStatements);

        // Construct the full UPDATE query using CASE
        $sql = "
            UPDATE applicants
            SET 
                ai_rate = (CASE $caseSql END),
                updated_at = ?
            WHERE 
                work_id = ? AND user_id IN (" . implode(',', array_fill(0, count($ids), '?')) . ")
        ";

        // Add updated_at and work_id bindings
        $bindings[] = $updatedAt;
        $bindings[] = $workId;

        // Add user_id bindings for the IN clause
        foreach ($ids as $userId) {
            $bindings[] = $userId;
        }

        // Execute the single batch update query
        DB::update($sql, $bindings);
    }
}
