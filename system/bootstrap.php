<?php declare(strict_types = 1);

use Whoops\Run;
use Whoops\Handler\PrettyPageHandler;
use System\Core\{
    App, Config
};

error_reporting(E_ALL);

/**
 * Load the env configuration
 */

Config::load(base_path() . '/config.ini');

/**
 * Register the error handler
 */

$whoops = new Run;

if (Config::app('debug')) {
    $whoops->pushHandler(new PrettyPageHandler);
} else {
    $whoops->pushHandler(function($e) {
        echo 'Friendly error page and send an email to the developer with the error: ' . $e;
    });
}

$whoops->register();

App::employ(
    Config::database(),
    Config::session()
);
