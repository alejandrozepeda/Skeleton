<?php

namespace App\Controllers;

use App\Models\Users;

class UsersController
{
    public function index()
    {
        $users = Users::all();

        return view('users.index', compact('users'));
    }

    public function create()
    {

    }

    public function store()
    {

    }

    public function show()
    {

    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function destroy()
    {

    }
}