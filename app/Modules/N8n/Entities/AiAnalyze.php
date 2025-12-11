<?php

namespace App\Modules\N8n\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class AiAnalyze extends Model
{
    protected $fillable = [
        "data",
        "type",
        "analyze_id",
        "analyze_type",

    ];

    public function analyz(): MorphTo
    {
        return $this->morphTo();
    }
}
