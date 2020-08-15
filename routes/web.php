<?php

/** @var Router $router */
// General routes
$router->get('', 'HomeController@index');

// Books related routes
$router->get('books/create', 'BookController@create');
$router->post('books/store', 'BookController@store');
$router->post('books/destroy', 'BookController@destroy');
$router->post('books/update', 'BookController@update');
$router->get('books/edit', 'BookController@edit');
$router->get('books/show', 'BookController@show');

// User related routes
$router->get('/register', 'UserController@register');
$router->post('/register', 'UserController@store');
$router->get('/login', 'UserController@login');
$router->post('/login', 'UserController@signin');
$router->post('/logout', 'UserController@logout');
