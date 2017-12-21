<?php

namespace System\Data\Auth;

class Session
{
    private $prefix;

    public function __construct($config)
    {
        $this->prefix = $config['prefix'];
    }

    public function init()
    {
        if (!session_id()) {
            session_start();
        }
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function get($key)
    {
        if (!array_key_exists($key, $_SESSION)) {
            return false;
        }

        return $_SESSION[$key];
    }

    public function pull($key)
    {
        $value = self::get($key);
        unset($_SESSION[$key]);

        return $value;
    }

    public function end()
    {
        session_destroy();
    }
}
