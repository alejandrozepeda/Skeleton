<?php

namespace System\Core;

use Exception;

class App
{
    private static $app;

    public static function bind($key, $value)
    {
        self::$app[$key] = $value;
    }

    public static function get($key)
    {
        if (!array_key_exists($key, self::$app)) {
            throw new Exception("No {$key} is bound in the container.");
        }

        return self::$app[$key];
    }
}
