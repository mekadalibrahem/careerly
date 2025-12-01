<?php

namespace App\Modules\N8n\Entities;

use Illuminate\Database\Eloquent\Model;

class WorkflowCall extends Model
{
    // protected $table = 'workflow_calls';
    protected $fillable = [
        'workflow_id',
        'type',
        'total_chunks',
        'chunk_number',
        'attempts',
        'status',
        'payload',
        'results',
        'user_id',
        'callback_received_at',
    ];
    protected $casts = [
        'payload' => 'array',
        // 'results' => 'array',
    ];
}
