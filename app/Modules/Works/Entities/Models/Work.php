<?php

namespace App\Modules\Works\Entities\Models;


use App\Models\Traits\Ownable;
use App\Models\User;
use App\Modules\Works\Enums\ApplicantStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

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
    public function appliedCount(): int
    {
        return DB::table('applicants')
            ->where([
                'work_id' => $this->id,
                'status' => ApplicantStatusEnum::ACCEPTED()
            ])
            ->count();
    }
    public function pendingCount(): int
    {
        return DB::table('applicants')
            ->where([
                'work_id' => $this->id,
                'status' => ApplicantStatusEnum::PENDING()
            ])
            ->count();
    }
}
