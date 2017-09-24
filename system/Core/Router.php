<?php

namespace System\Core;

use Exception;

class Router
{
    private static $routes;
    private static $regex;

    public static function __callStatic($method, $args)
    {
        $uri = trim($args[0], '/') . '/';

        self::$routes[] = [
            'uri' => $uri,
            'action' => $args[1],
            'method' => strtoupper($method)
        ];

        self::$regex[] = "#^{$uri}\$#";
    }

    public static function run($uri, $method)
    {
        foreach (self::$regex as $key => $value) {
            if (preg_match($value, $uri, $args) && $method === self::$routes[$key]['method']) {
                return self::callAction(
                    $args, ...explode('@', self::$routes[$key]['action'])
                );
            }
        }

        return null;
    }

    public static function callAction($args, $controller, $action)
    {
        $controller = "App\\Controllers\\{$controller}";

        if (!method_exists($controller, $action)) {
            throw new Exception("{$controller} does not respond to the {$action} method.");
        }

        array_shift($args);

        return call_user_func_array([new $controller, $action], $args);
    }
}
