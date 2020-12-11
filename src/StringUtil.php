<?php
namespace org\mmpp\util;

class StringUtil
{

    public static function isNull($value) : bool{
        if(empty($value)){
            return true;
        }
        return $value === null;
    }
}