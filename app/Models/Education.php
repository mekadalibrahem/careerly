<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Education extends Model
{
    /** @use HasFactory<\Database\Factories\EducationFactory> */
    use HasFactory;
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
