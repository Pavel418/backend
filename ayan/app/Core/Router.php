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

    public function delete($path, $action) {
        $this->addRoute('DELETE', $path, $action);
    }

    public function addRoute($method, $path, $action) {
        $this->routes[] = compact('method', 'path', 'action');
    }

    public function dispatch($uri) {
        $method = $_SERVER['REQUEST_METHOD'];
    
        $parts = explode('?', $uri, 2);
        $path = $parts[0];
        $query = isset($parts[1]) ? $parts[1] : null;
    
        foreach ($this->routes as $route) {
            if ($method === $route['method'] && $path === $route['path']) {
                list($controller, $method) = explode('@', $route['action']);
                $controller = "App\\Controllers\\{$controller}";
                if ($query !== null) {
                    (new $controller())->$method($query);
                } else {
                    (new $controller())->$method();
                }
                return;
            }
        }
    
        http_response_code(404);
        echo $uri;
        echo $method;
        echo "Page not found";
    }
}
