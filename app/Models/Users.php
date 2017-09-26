<?php

namespace App\Models;

class Users
{
    private static $table = 'users';

    public static function all()
    {
        return database()->select(self::$table,
            ['id', 'name', 'email']
        );
    }

    public static function find($id)
    {
        return database()->select(self::$table,
            ['id', 'name', 'email'],
            ['id' => $id]
        )[0];
    }

    public static function create($data)
    {
        return database()->insert(self::$table, [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password']
        ]);
    }

    public static function update($data, $id)
    {
        return database()->update(self::$table, [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password']
        ], ['id' => $id]);
    }

    public static function destroy($id)
    {
        return database()->delete(self::$table,
            ['id' => $id]
        );
    }
}
