<?php

namespace Kenjiefx\Lemonade\Logger;

class Console {

    /**
     * @var const OUTF
     */
    private const OUTF = "\033[0m";

    public function __construct()
    {
        define('LOG_SUCCESS',"\033[92m");
        define('LOG_ERROR',"\033[91m");
        define('LOG_WARNING',"\033[93m");
    }

    public static function log(
        string $message,
        )
    {
        echo $message.Self::OUTF.PHP_EOL;
    }

    public static function warn(
        string $message
        )
    {
        echo "\033[93m".$message.Self::OUTF.PHP_EOL;
    }

    public static function success(
        string $message
        )
    {
        echo "\033[92m".$message.Self::OUTF.PHP_EOL;
    }

    public static function error(
        string $message
        )
    {
        echo "\033[91m".$message.Self::OUTF.PHP_EOL;
    }


}
