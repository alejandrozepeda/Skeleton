<?php

namespace App\Models;

class Users
{
    public static function all()
    {
        return database()->select('users', [
            'id', 'name', 'email'
        ]);
    }
}
