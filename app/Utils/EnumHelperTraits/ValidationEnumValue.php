<?php

namespace App\Utils\EnumHelperTraits;

trait ValidationEnumValue
{
    public static function validate($value):bool
    {

       foreach (self::cases() as $case){
           if($case->value == $value){
               return true;
           }
       }
       return  false;

    }
}
