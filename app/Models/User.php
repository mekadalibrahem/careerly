<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Modules\Qualifications\Traits\Entities\HasQualifications;
use App\Modules\Works\Entities\Models\Applicant;
use App\Modules\Works\Entities\Models\Work;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use HasApiTokens;
    use HasQualifications;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'title',
        'password',
        "ban_at",
        "phone",
        "bio"
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'two_factor_confirmed_at'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            "ban_at" => 'datetime',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function jobs(): HasMany
    {
        return $this->hasMany(Work::class);
    }
    public function applicants(): HasMany
    {
        return $this->hasMany(Applicant::class);
    }
}
