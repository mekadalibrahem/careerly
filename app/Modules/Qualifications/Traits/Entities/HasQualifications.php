<?php

namespace App\Modules\Qualifications\Traits\Entities;

use App\Modules\Qualifications\Entities\Models\Course;
use App\Modules\Qualifications\Entities\Models\Education;
use App\Modules\Qualifications\Entities\Models\Project;
use App\Modules\Qualifications\Entities\Models\Skill;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

trait HasQualifications
{
    /**
     * Get the projects for the qualification.
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    /**
     * Get the courses for the qualification.
     */
    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    /**
     * Get the skills for the qualification.
     */
    public function skills(): HasMany
    {
        return $this->hasMany(Skill::class);
    }

    /**
     * Get the educations for the qualification.
     */
    public function educations(): HasMany
    {
        return $this->hasMany(Education::class);
    }
    public function scopeWithQualifications(Builder $query): Builder
    {
        return $query->with(['skills', 'educations', 'courses', 'projects']);
    }
}
