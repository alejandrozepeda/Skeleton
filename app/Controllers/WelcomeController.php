<?php

namespace App\Controllers;

class WelcomeController
{
    public static function index()
    {
        return view('welcome.index');
    }

    public static function home()
    {
        return view('welcome.home');
    }
}
