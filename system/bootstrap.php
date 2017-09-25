<?php

use System\Core\{App, Config};

Config::load(base_path() . '/config.ini');

App::employ(
    Config::database()
);
