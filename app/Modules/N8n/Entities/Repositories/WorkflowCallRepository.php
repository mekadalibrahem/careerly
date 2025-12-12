<?php

namespace App\Modules\N8n\Entities\Repositories;

use App\Modules\N8n\Entities\Dto\WorkflowCallDto;
use App\Modules\N8n\Entities\WorkflowCall;
use App\Modules\N8n\Enums\WorkflowStatusEnum;

class WorkflowCallRepository
{
    public function create(WorkflowCallDto $dto): WorkflowCall
    {
        return WorkflowCall::create($dto->toArray());
    }

    public function markCompleted(int $id, array $result): void
    {
        WorkflowCall::where('id', $id)->update([
            'status' => WorkflowStatusEnum::END->value,
            'results' => $result,
            'callback_received_at' => now(),
        ]);
    }

    public function markFailed(int $id, string $reason): void
    {
        WorkflowCall::where('id', $id)->update([
            'status' => WorkflowStatusEnum::TIMEOUT->value,
            'results' => json_encode(['error' => $reason]),
            'callback_received_at' => now(),
        ]);
    }

    public function incrementAttempts(int $id): void
    {
        WorkflowCall::where('id', $id)->increment('attempts');
    }
    /**
     * Group workflow calls by "type".
     */
    public function groupByType(string $workflowId)
    {
        return WorkflowCall::where('workflow_id', $workflowId)
            ->get()
            ->groupBy('type');
    }

    /**
     * Returns true if ALL chunks are completed.
     */
    public function isFullyCompleted(string $workflowId): bool
    {
        return WorkflowCall::where('workflow_id', $workflowId)
            ->whereNotIn('status', [WorkflowStatusEnum::END(), WorkflowStatusEnum::TIMEOUT()])
            ->count() === 0;
    }

    /**
     * Number of chunks still processing.
     */
    public function pendingCount(string $workflowId): int
    {
        return WorkflowCall::where('workflow_id', $workflowId)
            ->where('status', WorkflowStatusEnum::RUNNING->value)
            ->count();
    }

    /**
     * Get failed chunks.
     */
    public function failedChunks(string $workflowId)
    {
        return WorkflowCall::where('workflow_id', $workflowId)
            ->where('status', WorkflowStatusEnum::TIMEOUT->value)
            ->get();
    }

    /**
     * Merge all results into one collection (useful for AI scoring).
     */
    public function mergedResults(string $workflowId): array
    {
        return WorkflowCall::where('workflow_id', $workflowId)
            ->whereNotNull('results')
            ->get()
            ->flatMap(function ($row) {
                return is_array($row->results) ? $row->results : [];
            })
            ->toArray();
    }

    /**
     * Determine total chunks (useful when watching progress).
     */
    public function totalChunks(string $workflowId): int
    {
        return WorkflowCall::where('workflow_id', $workflowId)
            ->max('total_chunks') ?? 0;
    }

    /**
     * Determine completed chunks count.
     */
    public function completedChunks(string $workflowId): int
    {
        return WorkflowCall::where('workflow_id', $workflowId)
            ->where('status', WorkflowStatusEnum::END->value)
            ->count();
    }

    /**
     * Get current progress as percentage.
     */
    public function progress(string $workflowId): float
    {
        $completed = $this->completedChunks($workflowId);
        $total = $this->totalChunks($workflowId);

        if ($total === 0) return 0;

        return round(($completed / $total) * 100, 2);
    }

    public function getByWorkflowId(string $uuid)
    {
        return WorkflowCall::where("workflow_id", $uuid)->get();
    }
    public function getPage(string $uuid, $page)
    {
        return WorkflowCall::where([
            "workflow_id" => $uuid,
            "chunk_number" => $page
        ])->first();
    }
}
