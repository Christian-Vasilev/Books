<?php

namespace App\Libraries;

use Exception;
use ReflectionClass;

class Router
{
    const SEPARATOR = '@';

    protected $routes = [
        'GET' => [],
        'POST' => [],
    ];
    protected $namespace = 'App\\Controllers';

    /**
     * Sets a GET route to the list of routes
     *
     * @param $uri
     * @param $controller
     */
    public function get($uri, $controller)
    {
        $this->routes['GET'][$uri] = $controller;
    }

    /**
     * Sets a POST route to the list of routes
     *
     * @param $uri
     * @param $controller
     */
    public function post($uri, $controller)
    {
        $this->routes['POST'][$uri] = $controller;

    }

    /**
     * @param $uri
     * @param $requestType
     * @return mixed
     * @throws \ReflectionException
     */
    public function direct($uri, $requestType)
    {
        if (array_key_exists($uri, $this->routes[$requestType])) {
            return $this->parse($this->routes[$requestType][$uri]);
        }

        throw new Exception('No route defined for this URI.');
    }

    /**
     * Returns a list of routes
     *
     * @param $route
     * @return mixed
     * @throws \ReflectionException
     */
    public function parse($route)
    {
        $params = explode(self::SEPARATOR, $route);
        $method = $params[1];

        $controller = new ReflectionClass($this->namespace . DIRECTORY_SEPARATOR . $params[0]);

        if (!$controller->hasMethod($method)) {
            throw new Exception('Method not found');
        }

        return $controller->newInstance()->$method();
    }
}