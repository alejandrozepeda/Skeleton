<?php

function base_path()
{
    return dirname(__DIR__) . '/';
}

function app_path()
{
    return base_path() . 'app/';
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

function view($view, $data = [])
{
    \System\Core\Response::view($view, $data);
}
