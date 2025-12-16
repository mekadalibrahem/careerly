<?php

namespace  App\Utils\Models;

use Illuminate\Database\Eloquent\Builder;

trait WithScopeEnum
{
    protected function scopeEnum(Builder $query ,$enumClass , $kry , $case): Builder
    {

        if(is_array($case)){
            $filtered_cases = array_filter($case , static fn($c) => $enumClass::validate($c));
            return  $query->whereIn("priority" , $filtered_cases);
        }
        if($enumClass::validate($case)){
            return  $query->where("priority" ,$case);
        }

        throw new \InvalidArgumentException("invalid  argument value [$case] should string|array of one of values [" . implode("," ,$enumClass::values()) . "]");

    }
}

