<?php

use System\Core\Router;

Router::get('', 'WelcomeController@index');
Router::get('home', 'WelcomeController@home');

Router::get('users', 'UsersController@index');
Router::get('users/create', 'UsersController@create');
Router::get('users/([0-9]+)', 'UsersController@show');
Router::get('users/([0-9]+)/edit', 'UsersController@edit');
Router::get('users/([0-9]+)/destroy', 'UsersController@destroy');
Router::post('users', 'UsersController@store');
Router::post('users/([0-9]+)', 'UsersController@update');
