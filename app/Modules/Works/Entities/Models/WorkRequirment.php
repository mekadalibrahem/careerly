<?php

namespace App\Modules\Works\Entities\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkRequirment extends Model
{
    /** @use HasFactory<\Database\Factories\WorkRequirmentFactory> */
    use HasFactory;
    protected $fillable = [
        "name",
        "description",
        "level",
        "work_id",
        "created_at",
        "updated_at",
    ];

    public function work(): BelongsTo
    {
        return $this->belongsTo(Work::class);
    }
}
