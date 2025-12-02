<?php

namespace App\Modules\Qualifications\Entities\Models;


use App\Models\Traits\Ownable;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{

    use HasFactory;
    use Ownable;
    protected $fillable = [
        "id",
        "name",
        "user_id",
        "description",
        "tools",
        "url",
        'created_at',
        "updated_at"
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
