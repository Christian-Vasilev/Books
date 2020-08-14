<?php

/** @var Router $router */
$router->get('books/create', 'BookController@create');
$router->post('books/store', 'BookController@store');
$router->get('register', 'HomeController@index');
$router->post('register', 'UserController@index');