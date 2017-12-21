<?php

function base_path()
{
    return dirname(__DIR__) . '/';
}

function app_path()
{
    return base_path() . 'app/';
}

function views_path()
{
    return app_path() . 'Views/';
}

function public_path()
{
    return base_path() . 'public/';
}

function dd($data)
{
    \System\Core\Response::dd($data);
}

function json($data, $code)
{
    \System\Core\Response::json($data, $code);
}

function redirect($url, $code = 302)
{
    \System\Core\Response::redirect($url, $code);
}

function view($layout, $view, $data = [], $code = 200)
{
    \System\Core\Response::view($layout, $view, $data, $code);
}

function database()
{
    return \System\Core\App::database();
}

function session()
{
    return \System\Core\App::session();
}

function cache()
{
    return \System\Core\App::cache();
}

function slug($slug)
{
    $slug = preg_replace('/[`^~\'"]/', null, iconv('UTF-8', 'ASCII//TRANSLIT', $slug));
    $slug = preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', $slug);
    $slug = preg_replace('~[^0-9a-z]+~i', '-', $slug);

    return strtolower(trim($slug, '-'));
}
