<?php

namespace System\Core;

use Exception;

class Response
{
    public static function dd($data)
    {
        echo '<pre>';
        var_dump($data);
        echo '</pre>';

        exit();
    }

    public static function json($data, $code)
    {
        http_response_code($code);
        $encoded = json_encode($data);

        header('Content-Type: application/json');
        header('Content-Length:' . strlen($encoded));

        exit($encoded);
    }

    public static function redirect($url, $code = 302)
    {
        http_response_code($code);

        header("Status: {$code}");
        header("Location: /{$url}");

        exit();
    }

    public static function view($layout, $view, $data = [], $code = 200)
    {
        $layout = views_path() . str_replace('.', '/', $layout) . '.php';
        $view = views_path() . str_replace('.', '/', $view) . '.php';

        if (!file_exists($layout)) {
            throw new Exception("No layout {$layout} file found.");
        }

        if (!file_exists($view)) {
            throw new Exception("No view {$view} file found.");
        }

        http_response_code($code);
        extract($data);
        require($layout);

        exit();
    }
}
