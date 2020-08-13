<?php

/** @var Router $router */
$router->get('', 'HomeController@index');
$router->get('register', 'HomeController@index');
$router->post('register', 'UserController@index');
