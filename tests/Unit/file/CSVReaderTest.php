<?php
namespace Unit\file;

use org\mmpp\util\file\CSVReader;
use PHPUnit\Framework\TestCase;

class CSVReaderTest extends TestCase
{

    /**
     *
     * CSVReader::readだけのしけん
     */
    public function test_read(){
        $data = CSVReader::read(__DIR__ . '/../../../resources/tests/Unit/file/csv.csv');

        $this->assertCount(3,$data);
        $this->assertEquals('2020/11/22 22:00',$data[0][0]);
        $this->assertEquals('リース',$data[0][1]);

        $this->assertEquals('2020/11/22 23:00',$data[1][0]);
        $this->assertEquals('並ぶ',$data[1][1]);

        $this->assertEquals('2020/11/23 00:00',$data[2][0]);
        $this->assertEquals('アトラクション',$data[2][1]);

    }
}
