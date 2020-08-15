<?php

use App\Libraries\Router;

error_reporting(E_ALL);
ini_set('display_errors', 'On');

require_once '../app/bootstrap.php';

// Create the router
$router = new Router;
// Load all the routes related to the instance
require_once '../routes/web.php';

// Direct trafic to a specific location
$router->direct(
    trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'),
    $_SERVER['REQUEST_METHOD']
);
