<?php

namespace  App\Modules\Exports\Entities;

use App\Models\Traits\Ownable;
use App\Models\User;
use App\Modules\Exports\Traits\ModelsTraits\WithExpired;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Download extends  Model
{
    use Ownable;
    use WithExpired;
    protected $fillable = [
        'user_id',
        'path',
        'type',
    ];

    public  function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
