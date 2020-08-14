<?php

namespace App\Interfaces\Sessions;

interface FlashSessionInterface
{
    public static function create($name, $value);
    public static function exists($name);
    public static function read($name);
}