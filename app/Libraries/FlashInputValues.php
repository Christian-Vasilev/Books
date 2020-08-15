<?php


namespace App\Libraries;

use App\Interfaces\Sessions\FlashSessionInterface;

class FlashInputValues implements FlashSessionInterface
{
    public static function create($name, $value)
    {
        $_SESSION['inputs'][$name] = $value;
    }

    public static function read($name)
    {
        if (isset($_SESSION['inputs'][$name])) {
            $message = $_SESSION['inputs'][$name];
            unset($_SESSION['inputs'][$name]);

            echo trim($message);
        }
    }

    public static function exists($name)
    {
        return isset($_SESSION['inputs'][$name]);
    }
}