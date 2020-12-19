<?php


namespace org\mmpp\util;


use org\mmpp\util\exception\validation\EMailAddressValidationException;
use org\mmpp\util\exception\validation\NumberValidationException;
use org\mmpp\util\exception\validation\PhoneNumberException;
use org\mmpp\util\exception\validation\ZipCodeValidationException;

/**
 * 入力チェックツール
 * Class ValidateUtil
 * @package org\mmpp\util
 */
class ValidateUtil
{

    /**
     * 数値判断
     * @param int|string $current_value 被対象変数
     * @return bool 判断結果 ( true : OK )
     * @throws NumberValidationException
     */
    public static function validateNumber($current_value): bool
    {
        if($current_value === null){
            throw new NumberValidationException();
        }

        $value = mb_convert_kana($current_value,'a');

        if(!is_numeric($value)){
            throw new NumberValidationException();
        }
        return true;
    }

    /**
     * 郵便番号チェック
     * @param string $current_zip 被対象変数
     * @return bool 判断結果 ( true : OK )
     * @throws ZipCodeValidationException
     */
    public static function validateZipCode(string $current_zip): bool
    {

        if($current_zip === ''){
            throw new ZipCodeValidationException('郵便番号が空欄',ZipCodeValidationException::EMPTY);
        }
        $zip = mb_convert_kana($current_zip,'a');

        if(! preg_match('/^([0-9０-９\-ー]+)$/u',$zip)){
            throw new ZipCodeValidationException('郵便番号に不要な文字列が含まれています',ZipCodeValidationException::SYMBOL);
        }
        if( !preg_match('/^([0-9０-９]{3})[\-ー]?([0-9０-９]{4})$/u',$zip)){
            throw new ZipCodeValidationException('郵便番号の書式が正しくありません',ZipCodeValidationException::SYNTAX);
        }

        return true;
    }

    /**
     * 電話番号チェック
     * @param string $current_phone 被対象変数
     * @return bool 判断結果 ( true : OK )
     * @throws PhoneNumberException
     */
    public static function validationPhoneNumber(string $current_phone): bool
    {
        $phone = str_replace( ['-','(',')'],'',mb_convert_kana($current_phone,'a'));
        if(! preg_match('/^([0-9０-９\-ー+＋()（）]+)$/u',$phone)){
            throw new PhoneNumberException('電話番号に不要な文字列が含まれています',ZipCodeValidationException::SYMBOL);
        }
        if(! preg_match('/^[0-9+]([0-9０-９\-ー+＋()（）]+)$/u',$phone)){
            throw new PhoneNumberException('電話番号の書式が正しくありません',ZipCodeValidationException::SYNTAX);
        }
        if(preg_match('/^[1-9+]¥d¥d{9,10}$/',$phone)){
            // + 0以外で始めるのは国際番号

            // TODO 国際番号は検討中
            return true;
        }
        //
        if( preg_match('/^[0-9]¥d¥d{9,10}$/',$phone)){
            throw new PhoneNumberException('電話番号が正しくありません',ZipCodeValidationException::SYNTAX);
        }
        if( strlen($phone) < 9) {
            throw new PhoneNumberException('電話番号が正しくありません',ZipCodeValidationException::SYNTAX);
        }
        return true;
    }

    public static function validationEMailAddress(string $string)
    {

        if(! filter_var($string, FILTER_VALIDATE_EMAIL)){
            throw new EMailAddressValidationException('電話番号に不要な文字列が含まれています',ZipCodeValidationException::SYMBOL);
        }


        return true;
    }
}