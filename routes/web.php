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

// Collection related routes
$router->post('collection/store', 'CollectionController@store');
$router->get('collection/show', 'CollectionController@show');
$router->post('collection/delete', 'CollectionController@delete');

// User related routes
$router->get('/profile', 'UserController@profile');
$router->post('/profile', 'UserController@update');
$router->post('/password-change', 'UserController@changePassword');
$router->get('/register', 'UserController@register');
$router->post('/register', 'UserController@store');
$router->get('/users', 'UserController@index');
$router->post('/users/activate', 'UserController@activate');
$router->post('/users/deactivate', 'UserController@deactivate');
$router->get('/login', 'UserController@login');
$router->post('/login', 'UserController@signin');
$router->post('/logout', 'UserController@logout');
