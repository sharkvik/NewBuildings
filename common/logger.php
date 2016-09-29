<?php
class Logger
{
    protected static $Content = '';

    static function Debug( $log )
    {
        self::$Content .= 'Trace: '.$log.'<br/>';
    }

    static function Show()
    {
        echo self::$Content;
        self::$Content = '';
    }
}