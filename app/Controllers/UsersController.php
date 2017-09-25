<?php

namespace App\Controllers;

class UsersController
{
    public function index()
    {
        $users = database()->select('users', [
            'id', 'name', 'email'
        ]);

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