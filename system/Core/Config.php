<?php

namespace System\Core;

use Exception;

class Config
{
    private static $config;

    public static function __callStatic($key, $value)
    {
        $value = array_shift($value);

        if (!array_key_exists($value, self::$config[$key])) {
            throw new Exception("No {$key}['{$value}'] is bound in the container.");
        }

        return self::$config[$key][$value];
    }

    public static function load($file)
    {
        if (!file_exists($file)) {
            throw new Exception("No {$file} file found.");
        }

        self::$config = parse_ini_file($file, true, INI_SCANNER_TYPED);
    }
}
