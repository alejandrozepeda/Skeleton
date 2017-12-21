<?php

namespace System\Data\Cache;

class CacheBuilder
{
    private $memcached;

    public function __construct($memcached)
    {
        $this->memcached = $memcached;
    }

    public function get($key)
    {
        return $this->memcached->get($key);
    }
    public function set($key, $value, $ttl = null)
    {
        $expiry = is_null($ttl) ? $this->expiry : $ttl;
        return $this->memcached->set($key, $value, $expiry);
    }
    public function delete($key)
    {
        return $this->memcached->delete($key);
    }
    public function getStats()
    {
        return $this->memcached->getStats()[$this->host . ':' . $this->port];
    }
}
