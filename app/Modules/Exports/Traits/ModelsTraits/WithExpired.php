<?php
namespace App\Modules\Exports\Traits\ModelsTraits;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;

trait  WithExpired
{
    #[Scope]
    public function  expired(Builder $query) : void
    {
        $query->whereNotNull("expired_at");
    }
    #[Scope]
    public function valid(Builder $query) : void
    {
        $query->whereNull("expired_at");
    }
    public function  isExpired():bool
    {
        return ($this->expired_at != null);
    }

    public function markAsExpired():bool
    {
        $this->expired_at = Carbon::now();
        return  $this->save();
    }
}
