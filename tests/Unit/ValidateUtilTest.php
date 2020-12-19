<?php


namespace Unit;


use org\mmpp\util\exception\validation\EMailAddressValidationException;
use org\mmpp\util\exception\validation\NumberValidationException;
use org\mmpp\util\exception\validation\PhoneNumberException;
use org\mmpp\util\exception\validation\ZipCodeValidationException;
use org\mmpp\util\ValidateUtil;
use PHPUnit\Framework\TestCase;

/**
 * Class ValidateUtilTest
 * @package Unit
 */
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
        $this->assertTrue(ValidateUtil::validateNumber('１') , '数字文字列の試験');
    }

    /**
     * 郵便番号チェック
     * @throws ZipCodeValidationException
     */
    public function test_validationZipCode(){

        $this->assertTrue(ValidateUtil::validateZipCode('585-0051'),'フル文字列');
        $this->assertTrue(ValidateUtil::validateZipCode('5850051') , 'ハイフン抜き');
        $this->assertTrue(ValidateUtil::validateZipCode(5850051) , '数字のみ');

        $this->assertTrue(ValidateUtil::validateZipCode('５８５ー００５１'),'全角文字列');
        $this->assertTrue(ValidateUtil::validateZipCode('５８５００５１'),'全角文字列');
        $this->assertTrue(ValidateUtil::validateZipCode('５８５００５１'),'全角文字列');

        try{
            ValidateUtil::validateZipCode('');
            $this->assertTrue(false,'郵便番号が空欄');
        }catch(ZipCodeValidationException $e){
            $this->assertTrue(true);
        }
        try{
            ValidateUtil::validateZipCode('null');
            $this->assertTrue(false,'郵便番号が文字列の場合の試験');
        }catch(ZipCodeValidationException $e){
            $this->assertTrue(true);
        }
        try{
            ValidateUtil::validateZipCode('-null');
            $this->assertTrue(false);
        }catch(ZipCodeValidationException $e){
            $this->assertTrue(true,'マイナスが頭の文字列');
        }
        try{
            ValidateUtil::validateZipCode('585*0051');
            $this->assertTrue(false);
        }catch(ZipCodeValidationException $e){
            $this->assertEquals($e->getMessage(),'郵便番号に不要な文字列が含まれています');
            $this->assertTrue(true,'郵便番号に不要な文字列が含まれています');
        }
        try{
            ValidateUtil::validateZipCode('*5850051');
            $this->assertTrue(false);
        }catch(ZipCodeValidationException $e){
            $this->assertEquals($e->getMessage(),'郵便番号に不要な文字列が含まれています');
            $this->assertTrue(true,'郵便番号に不要な文字列が含まれています');
        }

    }

    /**
     * 電話番号チェック
     * @throws PhoneNumberException
     */
    public function test_validationPhoneNumber(){

        $this->assertTrue(ValidateUtil::validationPhoneNumber('0120-44-4444'),'フル文字列');
        $this->assertTrue(ValidateUtil::validationPhoneNumber('0120444444') , 'ハイフン抜き');

        $this->assertTrue(ValidateUtil::validationPhoneNumber('03-5321-1111'),'東京官庁');
        $this->assertTrue(ValidateUtil::validationPhoneNumber('0353211111'),'東京官庁');

        $this->assertTrue(ValidateUtil::validationPhoneNumber('080-1008-0000'),'携帯電話');
        $this->assertTrue(ValidateUtil::validationPhoneNumber('08010080000'),'携帯電話');
        $this->assertTrue(ValidateUtil::validationPhoneNumber('09011112222'),'携帯電話');

        $this->assertTrue(ValidateUtil::validationPhoneNumber('0980-87-2402'),'与那国島');
        $this->assertTrue(ValidateUtil::validationPhoneNumber('0980872402'),'与那国島');

        $this->assertTrue(ValidateUtil::validationPhoneNumber('(1-202)238-6700'),'在アメリカ合衆国日本国大使館');
        $this->assertTrue(ValidateUtil::validationPhoneNumber('（39）06487991'),'在イタリア日本国大使館');

        $this->assertTrue(ValidateUtil::validationPhoneNumber('０１２０−４４−４４４４'),'全角文字列');
        $this->assertTrue(ValidateUtil::validationPhoneNumber('０１２０４４４４４４'),'全角文字列');

        // 書式チェック
        // https://www.soumu.go.jp/main_sosiki/joho_tsusin/top/tel_number/number_shitei.html
        // https://www.j-lis.go.jp/spd/code-address/todouhuken/cms_16914188.html
        $this->assertTrue(ValidateUtil::validationPhoneNumber('011-231-4111'),'北海道');
        $this->assertTrue(ValidateUtil::validationPhoneNumber('017-722-1111'),'青森県');
        $this->assertTrue(ValidateUtil::validationPhoneNumber('018-860-1111'),'秋田県');
        $this->assertTrue(ValidateUtil::validationPhoneNumber('019-651-3111'),'岩手県');
        $this->assertTrue(ValidateUtil::validationPhoneNumber('022-211-2111'),'宮城県');
        $this->assertTrue(ValidateUtil::validationPhoneNumber('029-301-1111'),'茨城県');
        $this->assertTrue(ValidateUtil::validationPhoneNumber('023-630-2211'),'山形県');
        $this->assertTrue(ValidateUtil::validationPhoneNumber('024-521-1111'),'福島県');

        $this->assertTrue(ValidateUtil::validationPhoneNumber('028-623-2323'),'栃木県');
        $this->assertTrue(ValidateUtil::validationPhoneNumber('027-223-1111'),'群馬県');
        $this->assertTrue(ValidateUtil::validationPhoneNumber('048-824-2111'),'埼玉県');
        $this->assertTrue(ValidateUtil::validationPhoneNumber('043-223-2110'),'千葉県');
        $this->assertTrue(ValidateUtil::validationPhoneNumber('03-5321-1111'),'東京都');
        $this->assertTrue(ValidateUtil::validationPhoneNumber('045-210-1111'),'神奈川県');

        $this->assertTrue(ValidateUtil::validationPhoneNumber('025-285-5511'),'新潟県');
        $this->assertTrue(ValidateUtil::validationPhoneNumber('076-431-4111'),'富山県');
        $this->assertTrue(ValidateUtil::validationPhoneNumber('076-225-1111'),'石川県');
        $this->assertTrue(ValidateUtil::validationPhoneNumber('0776-21-1111'),'福井県');

        $this->assertTrue(ValidateUtil::validationPhoneNumber('055-237-1111'),'山梨県');
        $this->assertTrue(ValidateUtil::validationPhoneNumber('026-232-0111'),'長野県');
        $this->assertTrue(ValidateUtil::validationPhoneNumber('058-272-1111'),'岐阜県');
        $this->assertTrue(ValidateUtil::validationPhoneNumber('054-221-2455'),'静岡県');
        $this->assertTrue(ValidateUtil::validationPhoneNumber('052-961-2111'),'愛知県');
        $this->assertTrue(ValidateUtil::validationPhoneNumber('059-224-3070'),'三重県');

        $this->assertTrue(ValidateUtil::validationPhoneNumber('077-528-3993'),'滋賀県');
        $this->assertTrue(ValidateUtil::validationPhoneNumber('075-451-8111'),'京都府');
        $this->assertTrue(ValidateUtil::validationPhoneNumber('06-6941-0351'),'大阪府');
        $this->assertTrue(ValidateUtil::validationPhoneNumber('078-341-7711'),'兵庫県');
        $this->assertTrue(ValidateUtil::validationPhoneNumber('078-341-7711'),'奈良県');
        $this->assertTrue(ValidateUtil::validationPhoneNumber('073-432-4111'),'和歌山県');

        $this->assertTrue(ValidateUtil::validationPhoneNumber('0857-26-7111'),'鳥取県');
        $this->assertTrue(ValidateUtil::validationPhoneNumber('0852-22-5111'),'島根県');
        $this->assertTrue(ValidateUtil::validationPhoneNumber('086-224-2111'),'岡山県');
        $this->assertTrue(ValidateUtil::validationPhoneNumber('082-228-2111'),'広島県');
        $this->assertTrue(ValidateUtil::validationPhoneNumber('083-922-3111'),'山口県');

        $this->assertTrue(ValidateUtil::validationPhoneNumber('088-621-2500'),'徳島県');
        $this->assertTrue(ValidateUtil::validationPhoneNumber('087-831-1111'),'香川県');
        $this->assertTrue(ValidateUtil::validationPhoneNumber('089-941-2111'),'愛媛県');
        $this->assertTrue(ValidateUtil::validationPhoneNumber('088-823-1111'),'高知県');

        $this->assertTrue(ValidateUtil::validationPhoneNumber('092-651-1111'),'福岡県');
        $this->assertTrue(ValidateUtil::validationPhoneNumber('0952-24-2111'),'佐賀県');
        $this->assertTrue(ValidateUtil::validationPhoneNumber('095-824-1111'),'長崎県');
        $this->assertTrue(ValidateUtil::validationPhoneNumber('096-383-1111'),'熊本県');
        $this->assertTrue(ValidateUtil::validationPhoneNumber('097-536-1111'),'大分県');
        $this->assertTrue(ValidateUtil::validationPhoneNumber('097-536-1111'),'宮崎県');
        $this->assertTrue(ValidateUtil::validationPhoneNumber('099-286-2111'),'鹿児島県');
        $this->assertTrue(ValidateUtil::validationPhoneNumber('098-866-2333'),'沖縄県');


        $this->assertTrue(ValidateUtil::validationPhoneNumber('+91-11-4610-4610'),'在インド日本国大使館');
        $this->assertTrue(ValidateUtil::validationPhoneNumber('+91-11-2688-5587'),'在インド日本国大使館');
        $this->assertTrue(ValidateUtil::validationPhoneNumber('+91-11-4610-4610'),'在インド日本国大使館　領事部');

        try{
            ValidateUtil::validationPhoneNumber('0980-87-240');
            ValidateUtil::validationPhoneNumber('0980-87-40');
            ValidateUtil::validationPhoneNumber('0980-8-2');
            $this->assertTrue(false,'加入者番号なし');
        }catch(PhoneNumberException $e){
            $this->assertTrue(true);
        }


        // 例外パターン
        try{
            ValidateUtil::validationPhoneNumber('');
            $this->assertTrue(false,'郵便番号が空欄');
        }catch(PhoneNumberException $e){
            $this->assertTrue(true);
        }
        try{
            ValidateUtil::validationPhoneNumber('null');
            $this->assertTrue(false,'郵便番号が文字列の場合の試験');
        }catch(PhoneNumberException $e){
            $this->assertTrue(true);
        }
        try{
            ValidateUtil::validationPhoneNumber('-null');
            $this->assertTrue(false);
        }catch(PhoneNumberException $e){
            $this->assertTrue(true,'マイナスが頭の文字列');
        }
    }

    /**
     * メールアドレスチェック
     * @throws EMailAddressValidationException
     */
    public function test_validationEMailAddress()
    {

        $this->assertTrue(ValidateUtil::validationEMailAddress('sample@sample.com'), '正常動作');
        $this->assertTrue(ValidateUtil::validationEMailAddress('Abc@example.com'), '正常動作');
        $this->assertTrue(ValidateUtil::validationEMailAddress('Abc.123@example.com'), '正常動作');
        $this->assertTrue(ValidateUtil::validationEMailAddress('user+mailbox/department=shipping@example.com'), '正常動作');
        $this->assertTrue(ValidateUtil::validationEMailAddress("!#$%&'*+-/=?^_`.{|}~@example.com"), '正常動作');
        $this->assertTrue(ValidateUtil::validationEMailAddress('"Abc@def"@example.com'), '正常動作');
        $this->assertTrue(ValidateUtil::validationEMailAddress('"Fred\ Bloggs"@example.com'), '正常動作');

//        $this->assertTrue(ValidateUtil::validationEMailAddress('sample@192.68.0.1'), '正常動作');
        $this->assertTrue(ValidateUtil::validationEMailAddress('sample@[192.68.0.1]'), '正常動作');

//        $this->assertTrue(ValidateUtil::validationEMailAddress('safoo <foo@example.com>'), '正常動作');
//        $this->assertTrue(ValidateUtil::validationEMailAddress('<foo@example.com>'), '正常動作');

        try {
            ValidateUtil::validationEMailAddress('samplesample.com');
            $this->assertTrue(false,'アットマークなし');
        }catch (EMailAddressValidationException $e){
            $this->assertTrue(true);
        }
        try {
            ValidateUtil::validationEMailAddress('sample@sample.com.');
            $this->assertTrue(false,'末尾に.は表記エラー');
        }catch (EMailAddressValidationException $e){
            $this->assertTrue(true);
        }
        try {
            ValidateUtil::validationEMailAddress('sample@.sample.com');
            $this->assertTrue(false,'末尾に.は表記エラー');
        }catch (EMailAddressValidationException $e){
            $this->assertTrue(true);
        }
        try {
            ValidateUtil::validationEMailAddress('sample@sample');
            $this->assertTrue(false,'ドメインの表記エラー');
        }catch (EMailAddressValidationException $e){
            $this->assertTrue(true);
        }
        try {
            ValidateUtil::validationEMailAddress('sample@localhost');
            $this->assertTrue(false,'ドメインの表記エラー');
        }catch (EMailAddressValidationException $e){
            $this->assertTrue(true);
        }
        try {
            ValidateUtil::validationEMailAddress('');
            $this->assertTrue(false,'空欄');
        }catch (EMailAddressValidationException $e){
            $this->assertTrue(true);
        }

    }
}