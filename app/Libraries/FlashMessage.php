<?php


namespace App\Libraries;



use App\Interfaces\Sessions\FlashSessionInterface;

class FlashMessage implements FlashSessionInterface
{
    public static function create($name, $value)
    {
        if (!self::exists($name)) {
            $_SESSION['messages'][] = [$name => $value];
        }
    }

    public static function read($name)
    {
        // Assign all errors to a variable for easy iteration
        $errors = isset($_SESSION['messages']) ? $_SESSION['messages'] : [];

        // Filter errors and save only the one with the requested name if exists.
        $error = array_filter($errors, function ($item) use ($name) {
            return array_key_exists($name, $item);
        });

        if (!empty($error)) {
            // Unset the error from messages with the found key.
            unset($_SESSION['messages'][key($error)]);

            return $error[key($error)][$name];
        }

        return '';
    }

    public static function exists($name)
    {
        $errors = isset($_SESSION['messages']) ? $_SESSION['messages'] : [];

        return !empty(array_filter($errors, function ($item) use ($name) {
            return array_key_exists($name, $item);
        }));
    }

}