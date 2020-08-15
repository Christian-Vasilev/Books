<?php


namespace App\Libraries;


use App\Models\User;

class Auth
{
    public static function user()
    {
        if (isset($_SESSION['user'])) {
            return (new User())->find($_SESSION['user']);
        }

        return null;
    }

    public static function isAdmin()
    {
        if (!is_null(self::user())) {
            return self::user()->isAdmin();
        }

        return false;
    }

    public static function logout()
    {
        if (isset($_SESSION['user'])) {
            unset($_SESSION['user']);

            return true;
        }

        return true;
    }
}