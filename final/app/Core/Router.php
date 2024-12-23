<?php

namespace App\Core;

class Router {
    protected $routes = [];

    public function get($path, $action) {
        $this->addRoute('GET', $path, $action);
    }

    public function post($path, $action) {
        $this->addRoute('POST', $path, $action);
    }

    public function addRoute($method, $path, $action) {
        $this->routes[] = compact('method', 'path', 'action');
    }

    public function dispatch($uri) {
        $method = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $route) {
            if ($method === $route['method'] && $uri === $route['path']) {
                list($controller, $method) = explode('@', $route['action']);
                $controller = "App\\Controllers\\{$controller}";
                (new $controller())->$method();
                return;
            }
        }

        http_response_code(404);
        echo $uri;
        echo $method;
        echo "Page not found";
    }
}
