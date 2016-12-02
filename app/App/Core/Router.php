<?php

namespace App\Core;

use Exception;
use App\Services\Utility;

/**
 * Router class which handles application rooting. This is a simple implementation of
 * Dave Hollingworth's php-mvc framework project
 * @see https://github.com/daveh/php-mvc php-mvc framework
 */
class Router {

    /**
     * Routes / routing table
     * @var array
     */
    private $routes = [];

    /**
     * Matched route parameters
     * @var array
     */
    private $params = [];

    /**
     * Add route to the routes table
     * @param string $route  URL route
     * @param array  $params parameters like controller, action
     */
    public function addRoute($route, $params = [])
    {
        // escape forward slashes
        $route = preg_replace('/\//', '\\/', $route);
        // convert variables {controller}, {action}
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);
        // convert variables with custom regular expressions e.g. {id:\d+}
        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);
        // add start and end tags
        $route = '/^' . $route . '$/i';
        // add route with params to routes storage
        if ($this->routes[$route] = $params) {
            return true;
        }
    }

    /**
     * Match URL route to the routes in the routing table
     * and set parameters if route is found
     * @param  string $url URL route
     * @return boolean         if route if found true otherwise false
     */
    private function match($url)
    {
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        $params[$key] = $match;
                    }
                }
                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    /**
     * Dispatch the route, create Controller object
     * and run method
     * @param  string $uri URL route
     * @return void
     */
    public function dispatch($uri)
    {
        if ($this->match($uri)) {
            $controller = $this->params['controller'];
            $controller = ucfirst($controller) . 'Controller';
            $controller = "App\Controllers\\$controller";

            if (class_exists($controller)) {
                $controllerObj = new $controller($this->params);
                $method = !empty($this->params['method']) ? $this->params['method'] : 'index';
                $method = Utility::convertToCamelCase($method);

                if (is_callable([$controllerObj, $method])) {
                    $controllerObj->$method();
                    return;
                }
            }
        }
        // if no class or method were found, use error controller
        //  to display error message
        $controller = "App\Controllers\ErrorController";
        $controllerObj = new $controller;
        $method = 'index';
        $method = Utility::convertToCamelCase($method);
        if (is_callable([$controllerObj, $method])) {
            $controllerObj->$method();
        }
    }

    /**
     * Get all routes from the routes table
     * @return array all routes present in the routes table
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * Get the matched parameters
     * @return array currenty matched parameters
     */
    public function getParams()
    {
        return $this->params;
    }
}
