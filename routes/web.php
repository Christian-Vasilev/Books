<?php

/** @var Router $router */
$router->get('books/create', 'BookController@create');
$router->post('books/store', 'BookController@store');
$router->post('books/destroy', 'BookController@destroy');
$router->post('books/update', 'BookController@update');
$router->get('books/edit', 'BookController@edit');
$router->get('books/show', 'BookController@show');
$router->get('/', 'HomeController@index');
$router->post('register', 'UserController@index');