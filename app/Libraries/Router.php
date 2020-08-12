<?php

namespace App\Libraries;

use Exception;
use ReflectionClass;

class Router
{
    const SEPARATOR = '@';

    protected $routes = [];
    protected $namespace = 'App\\Controllers';

    public function define(array $routes)
    {
        $this->routes = $routes;
    }

    public function direct($uri)
    {
        if (array_key_exists($uri, $this->routes)) {
            return $this->parse($this->routes[$uri]);
        }

        throw new Exception('No route defined for this URI.');
    }

    public function parse(string $route)
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