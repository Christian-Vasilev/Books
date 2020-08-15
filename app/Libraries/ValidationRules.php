<?php


namespace App\Libraries;


class ValidationRules
{
    public static function required($value)
    {
        return !empty($value);
    }

    public static function password($password, $repeatedPassword)
    {
        return $password === $repeatedPassword;
    }

    public static function email($value)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    public static function min($value, $min)
    {
        return strlen($value) >= $min;
    }

    public static function mime($file, $allowedTypes)
    {
        if (isset($file['tmp_name']) && !empty($file['tmp_name'])) {
            return in_array(mime_content_type($file['tmp_name']), $allowedTypes);
        }

        return false;
    }

    public static function image($file)
    {
        return isset($file['error']) ? $file['error'] === 0 : false;
    }

    public static function isValidToken($value)
    {
        return isValidCsrf($value);
    }
}