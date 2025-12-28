<?php

namespace App\Modules\Qualifications\Entities\Models;

use App\Models\User;
use App\Models\Traits\Ownable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Skill extends Model
{

    use HasFactory;
    use Ownable;

    protected $fillable = [
        "id",
        "name",
        "user_id",
        'created_at',
        "updated_at",
        'level'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
