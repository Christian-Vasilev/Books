<?php

/** @var Router $router */
$router->get('books/create', 'BookController@create');
$router->post('books/store', 'BookController@store');
$router->post('books/destroy', 'BookController@destroy');
$router->get('/', 'HomeController@index');
$router->post('register', 'UserController@index');