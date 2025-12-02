<?php

namespace App\Modules\Qualifications\Entities\Models;

use App\Models\User;
use App\Models\Traits\Ownable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Education extends Model
{
    /** @use HasFactory<\Database\Factories\EducationFactory> */
    use HasFactory;
    use Ownable;
    protected $fillable = [
        "id",
        "name",
        "user_id",
        "institution",
        "degree",
        "grade",
        "start_at",
        "end_at",
        'created_at',
        "updated_at"
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
