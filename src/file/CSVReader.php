<?php
namespace org\mmpp\util\file;


class CSVReader
{

    public static function read($file_path){
        $lines = [];
        // CSV取得
        $file = new \SplFileObject($file_path);
        $file->setFlags(
            \SplFileObject::READ_CSV |
            \SplFileObject::READ_AHEAD |
            \SplFileObject::SKIP_EMPTY |
            \SplFileObject::DROP_NEW_LINE
        );
        // 一行ずつ処理
        foreach($file as $line)
        {
            $lines[] = $line;
        }
        return $lines;
    }
}
