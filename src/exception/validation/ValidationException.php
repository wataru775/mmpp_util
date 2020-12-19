<?php
namespace org\mmpp\util\exception\validation;

use org\mmpp\util\exception\Exception;

class ValidationException extends Exception
{
    /**
     * 内容が空欄 or null
     */
    const EMPTY = 0x1;
    /**
     * 不当な文字
     */
    const SYMBOL = 0x10;

    /**
     * 構文エラー
     */
    const SYNTAX = 0x100;

}