<?php

require(dirname(__DIR__) . '/vendor/autoload.php');
require(dirname(__DIR__) . '/system/bootstrap.php');
require(dirname(__DIR__) . '/app/routes.php');

use System\Core\{Router, Request, Response};

Router::run(
    Request::uri(), Request::method()
);

Response::error('error.404');
