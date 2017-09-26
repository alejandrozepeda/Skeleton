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
        return view('users.create');
    }

    public function store()
    {
        Users::create($_POST);

        return redirect('users');
    }

    public function show($id)
    {
        $user = Users::find($id);

        return view('users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = Users::find($id);

        return view('users.edit', compact('user'));
    }

    public function update($id)
    {
        $user = Users::find($id);
        Users::update($_POST, $user['id']);

        return redirect('users');
    }

    public function destroy($id)
    {
        $user = Users::find($id);
        Users::destroy($user['id']);

        return redirect('users');
    }
}
