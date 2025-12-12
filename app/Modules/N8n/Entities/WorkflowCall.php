<?php

namespace App\Modules\N8n\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
