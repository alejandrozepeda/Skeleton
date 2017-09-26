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

        exit;
    }

    public static function json($data, $code)
    {
        http_response_code($code);
        $encoded = json_encode($data);

        header('Content-Type: application/json');
        header('Content-Length:' . strlen($encoded));

        exit($encoded);
    }

    public static function error($view = '', $code = 404)
    {
        $file = app_path() . 'Views/' . str_replace('.', '/', $view) . '.php';

        if (!file_exists($file)) {
            throw new Exception("No route defined.");
        }

        http_response_code($code);
        require($file);

        exit;
    }

    public static function redirect($url, $code = 302)
    {
        http_response_code($code);

        header("Status: {$code}");
        header("Location: /{$url}");

        exit;
    }

    public static function view($view, $data = [], $code = 200)
    {
        $file = app_path() . 'Views/' . str_replace('.', '/', $view) . '.php';

        if (!file_exists($file)) {
            throw new Exception("No view {$view} file found.");
        }

        http_response_code($code);
        extract($data);

        require(app_path() . 'Views/partials/header.php');
        require($file);
        require(app_path() . 'Views/partials/footer.php');

        exit;
    }
}
