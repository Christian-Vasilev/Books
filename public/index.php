<?php

use App\Libraries\Router;

error_reporting(E_ALL);
ini_set('display_errors', 'On');

require_once '../app/bootstrap.php';

$router = new Router;

require_once '../routes/web.php';

$router->direct(
    trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'),
    $_SERVER['REQUEST_METHOD']
);
