<?php

namespace App\Modules\SupportTickets\Entities;

use App\Models\Traits\Ownable;
use App\Models\User;
use App\Modules\SupportTickets\Enums\SupportTicketsPriorities;
use App\Utils\Models\WithScopeEnum;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Modules\SupportTickets\Enums\SupportTicketsStatus;
class SupportTicket extends Model
{
    use Ownable;
    use WithScopeEnum;

    protected $fillable = [
        "user_id",
        "status",
        "priority",
        "message",
        "subject",
        "note",
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    #[Scope]
    protected function priority(Builder $query, $priority = null): Builder
    {


        if(!$priority && !is_array($priority)){
            $priority = SupportTicketsPriorities::HIGH();
        }
        return $this->scopeEnum($query, SupportTicketsPriorities::class,"status" ,$priority);

    }
    #[Scope]
    protected function status(Builder $query, $status = null): Builder
    {

        if(!$status && !is_array($status)){
            $status = SupportTicketsStatus::OPEN();
        }
        return $this->scopeEnum($query, SupportTicketsStatus::class,"status" ,$status);
    }

}
