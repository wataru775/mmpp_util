<?php
namespace Unit;

use org\mmpp\util\StringUtil;
use PHPUnit\Framework\TestCase;

class StringUtilTest extends TestCase
{

    public function test_isNull(){
        $this->assertTrue(StringUtil::isNull(''));
        $this->assertTrue(StringUtil::isNull(null));
    }
}
