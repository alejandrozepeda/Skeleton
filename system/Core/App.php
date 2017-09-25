<?php

namespace System\Core;

use Exception;
use System\Data\Database\Connection;
use System\Data\Database\QueryBuilder;

class App
{
    private static $app;

    public static function bind($key, $value)
    {
        self::$app[$key] = $value;
    }

    public static function employ($database = null)
    {
        if (!empty($database)) {
            self::bind('database', new QueryBuilder(
                Connection::make($database)
            ));
        }
    }

    public static function __callStatic($key, $arguments)
    {
        if (!array_key_exists($key, self::$app)) {
            throw new Exception("No {$key} is bound in the container.");
        }

        return self::$app[$key];
    }
}
