<?php

use System\Core\Router;

Router::get('', 'WelcomeController@index');
Router::get('home', 'WelcomeController@home');
Router::get('users', 'UsersController@index');

