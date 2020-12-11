<?php


namespace Unit;


use org\mmpp\util\exception\validation\NumberValidationException;
use org\mmpp\util\ValidateUtil;
use PHPUnit\Framework\TestCase;

class ValidateUtilTest extends TestCase
{
    /**
     * 数値であるかの試験
     * @throws NumberValidationException
     */
    public function testValidateString(){
        try{
            ValidateUtil::validateNumber(null);
            $this->assertTrue(false,'数字がNullの場合の試験がNG');
        }catch(NumberValidationException $e){
            $this->assertTrue(true);
        }
        try{
            ValidateUtil::validateNumber('');
            $this->assertTrue(false,'数字が空欄である場合の試験');
        }catch(NumberValidationException $e){
            $this->assertTrue(true);
        }
        try{
            ValidateUtil::validateNumber('null');
            $this->assertTrue(false,'数字が文字列の場合の試験');
        }catch(NumberValidationException $e){
            $this->assertTrue(true);
        }
        try{
            $this->assertTrue(ValidateUtil::validateNumber('-null'));
        }catch(NumberValidationException $e){
            $this->assertTrue(true,'マイナスが頭の文字列');
        }
        $this->assertTrue(ValidateUtil::validateNumber(1),'数字である場合の試験');
        $this->assertTrue(ValidateUtil::validateNumber('1') , '数字文字列の試験');
        $this->assertTrue(ValidateUtil::validateNumber('-1') , 'マイナス文字列のチェック');
        $this->assertTrue(ValidateUtil::validateNumber(-1) , 'マイナスのチェック');
    }
    public function validationZip(){

    }
}