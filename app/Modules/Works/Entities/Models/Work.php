<?php

namespace App\Modules\Works\Entities\Models;


use App\Models\Traits\Ownable;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Work extends Model
{
    /** @use HasFactory<\Database\Factories\JobFactory> */
    use HasFactory;
    use Ownable;

    protected $fillable = [
        "name",
        "description",
        "company",
        "location",
        "type",
        "salary_range",
        'requirements',
        'benefits',
        "status",
        "user_id",

    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function workRequirements(): HasMany
    {
        return $this->hasMany(WorkRequirement::class);
    }
    public function applicants(): HasMany
    {
        return $this->hasMany(Applicant::class);
    }
}
