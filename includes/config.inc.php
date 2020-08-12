<?php 
// Database params
define('DATABASE', [
	'HOST' => 'localhost',
	'USER' => 'root',
	'PASSWORD' => '',
	'NAME' => 'books',
	'CHARSET' => 'utf8',
    'OPTIONS' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]
]);

// App root
define('APP_ROOT', dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR);
define('APP_NAME', 'My books');