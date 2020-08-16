<?php 
// Database params
define('DATABASE', [
	'HOST' => 'localhost',
	'USER' => 'root',
	'PASSWORD' => '',
	'NAME' => 'books',
	'CHARSET' => 'utf8',
    'OPTIONS' => [
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        // Make connection type persistent. See if there is already established connection
        PDO::ATTR_PERSISTENT => true,
    ]
]);

// App root
define('APP_ROOT', dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR);
define('APP_NAME', 'My books');
define('APP_URL', 'http://books.com');
define('PUBLIC_PATH', str_replace('\\', '/', dirname(__DIR__)) . '/public');