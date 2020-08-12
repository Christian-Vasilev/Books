<?php
require_once '../includes/config.inc.php';
require_once '../includes/helpers.php';


spl_autoload_extensions('.php');
spl_autoload_register(function ($className) {

    $file = APP_ROOT . $className . '.php';

    file_exists($file)
        ? require_once $file
        : die('File could not be loaded');
});