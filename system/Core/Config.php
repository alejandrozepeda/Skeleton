<?php

namespace System\Core;

use Exception;

class Config
{
    private static $config;

    public static function load($file)
    {
        if (!file_exists($file)) {
            throw new Exception("No {$file} file found.");
        }

        self::$config = parse_ini_file($file, true, INI_SCANNER_TYPED);
    }

    private static function exists($key, $arr)
    {
        if (!array_key_exists($key, $arr)) {
            throw new Exception("No {$key} is bound in the container.");
        }

        return $arr[$key];
    }

    public static function __callStatic($key, $value)
    {
        if(!empty($value)) {
            $value = array_shift($value);

            return self::exists($value, self::$config[$key]);
        }

        return self::exists($key, self::$config);
    }
}
