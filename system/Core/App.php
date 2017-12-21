<?php

namespace System\Core;

use Exception;
use System\Data\Auth\Session;
use System\Data\Cache\{
    CacheBuilder, Connection as CacheConnection
};
use System\Data\Database\{
    QueryBuilder, Connection
};

class App
{
    private static $app;

    public static function bind($key, $value)
    {
        self::$app[$key] = $value;
    }

    public static function employ($database = null, $session = null, $cache = null)
    {
        if (!empty($database)) {
            self::bind('database', new QueryBuilder(
                Connection::make($database)
            ));
        }

        if (!empty($session)) {
            self::bind('session', new Session($session));
            session()->init();
        }

        if (!empty($cache)) {
            self::bind('cache', new CacheBuilder(
                CacheConnection::make($cache)
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
