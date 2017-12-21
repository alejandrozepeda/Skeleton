<?php declare(strict_types = 1);

require(dirname(__DIR__) . '/vendor/autoload.php');
require(dirname(__DIR__) . '/system/bootstrap.php');
require(dirname(__DIR__) . '/app/routes.php');

use System\Core\{
    Router, Request, Response
};

Router::run(
    Request::uri(), Request::method()
);

Response::view('layouts.clean', 'error.404');
