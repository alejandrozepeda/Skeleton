<?php

namespace System\Data\Cache;

use Memcached;

class Connection
{
    public static function make($config)
    {
        $memcached = new Memcached();
        $memcached->addServer($config['host'], $config['port']);
        return $memcached;
    }
}
