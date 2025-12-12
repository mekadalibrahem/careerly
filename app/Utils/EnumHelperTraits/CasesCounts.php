<?php 

namespace App\Utils\EnumHelperTraits;


trait CasesCounts 
{
    public static function casesCount($counts , $default= 0){
        $result = [];
        foreach (self::cases() as $case) {
            $result[$case->value] = $counts[$case->value] ?? $default;
        }
        return $result;
    }
}
