<?php

namespace App\Controllers;

class WelcomeController
{
    public function index()
    {
        return view('welcome.index');
    }

    public function home()
    {
        return view('welcome.home');
    }
}
