<?php

namespace App\Modules\Works\Entities\Models;

use App\Models\Traits\Ownable;
use App\Models\User;
use App\Modules\N8n\Entities\Traits\HasAnalyzableTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Applicant extends Model
{
    /** @use HasFactory<\Database\Factories\ApplicantFactory> */
    use HasFactory;
    use Ownable;
    use HasAnalyzableTraits;
    protected $fillable = [
        "status",
        'user_id',
        'work_id',
        'created_at',
        'updated_at'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function work(): BelongsTo
    {
        return $this->belongsTo(Work::class);
    }
}
