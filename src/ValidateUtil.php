<?php


namespace org\mmpp\util;


use org\mmpp\util\exception\validation\NumberValidationException;

class ValidateUtil
{

    public static function validateNumber($value)
    {
        if($value === null){
            throw new NumberValidationException();
        }
        if(!is_numeric($value)){
            throw new NumberValidationException();
        }
        return true;
    }
}