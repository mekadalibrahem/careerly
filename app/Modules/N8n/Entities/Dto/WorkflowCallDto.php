<?php

namespace App\Modules\N8n\Entities\Dto;

use Carbon\Carbon;
use App\Modules\N8n\Enums\WorkflowStatusEnum;

class WorkflowCallDto
{
    public string $workflow_id;
    public string $type;
    public int $total_chunks;
    public int $chunk_number;
    public int $attempts = 1;
    public WorkflowStatusEnum $status;
    public ?array $payload = null;
    public ?array $results = null;
    public int $user_id;
    public ?Carbon $callback_received_at = null;
    public ?Carbon $created_at = null;
    public ?Carbon $updated_at = null;
    public function __construct(
        string $workflow_id,
        string $type,
        int $total_chunks,
        int $chunk_number,
        int $user_id,
        ?array $payload = null,
        WorkflowStatusEnum $status = WorkflowStatusEnum::RUNNING,
        int $attempts = 1,
        ?array $results = null,
        ?Carbon $callback_received_at = null
    ) {
        $this->workflow_id = $workflow_id;
        $this->type = $type;
        $this->total_chunks = $total_chunks;
        $this->chunk_number = $chunk_number;
        $this->user_id = $user_id;
        $this->status = $status;
        $this->attempts = $attempts;
        $this->payload = $payload;
        $this->results = $results;
        $this->callback_received_at = $callback_received_at;
    }
    /**
     * Create DTO from array (e.g. DB record).
     */
    public static function fromArray(array $data): self
    {
        return new self(
            workflow_id: $data['workflow_id'],
            type: $data['type'],
            total_chunks: $data['total_chunks'],
            chunk_number: $data['chunk_number'],
            user_id: $data['user_id'],
            status: WorkflowStatusEnum::from($data['status']),
            attempts: $data['attempts'] ?? 1,
            payload: isset($data['payload']) ? json_decode($data['payload'], true) : null,
            results: isset($data['results']) ? json_decode($data['results'], true) : null,
            callback_received_at: isset($data['callback_received_at'])
                ? Carbon::parse($data['callback_received_at'])
                : null
        );
    }
    /**
     * Convert DTO to array (for DB insert/update).
     */
    public function toArray(): array
    {
        return [
            'workflow_id'           => $this->workflow_id,
            'type'                  => $this->type,
            'total_chunks'          => $this->total_chunks,
            'chunk_number'          => $this->chunk_number,
            'attempts'              => $this->attempts,
            'status'                => $this->status->value,
            'payload'               => $this->payload ? json_encode($this->payload) : null,
            'results'               => $this->results ? json_encode($this->results) : null,
            'user_id'               => $this->user_id,
            'callback_received_at'  => $this->callback_received_at,
        ];
    }
}
