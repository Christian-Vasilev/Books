<?php


/** @var Router $router */
return $router->define([
    '' => 'HomeController@index',
    'home' => 'HomeController@home',
    'register' => 'UserController@register',
]);