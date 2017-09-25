<?php

namespace System\Data\Database;

use PDO;

class Connection
{
    public static function make($config)
    {
        return new PDO(
            $config['type'] . ':host=' . $config['host'] . ';dbname=' . $config['name'] . ';port' . $config['port'],
            $config['user'], $config['pass'], [
                PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION
            ]
        );
    }
}
