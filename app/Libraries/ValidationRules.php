<?php


namespace App\Libraries;


class ValidationRules
{
    public static function required($value)
    {
        return !empty($value);
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
        return !$file['error'] > 0;
    }
}