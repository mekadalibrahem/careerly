<?php

namespace App\Modules\N8n\Entities\Traits;

use App\Modules\N8n\Entities\AiAnalyze;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasAnalyzableTraits
{
    public function analyze(): MorphMany
    {
        return $this->morphMany(AiAnalyze::class, 'analyze');
    }
    public function latestAnalyze(): MorphOne
    {
        return $this->morphOne(AiAnalyze::class,'analyze')->latestOfMany();
    }
}
