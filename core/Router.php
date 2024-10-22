<?php 
namespace Core;

class Router {
    protected $routes = [];

    public function add($route, $action) 
    {
        // Thêm route vào danh sách các route đã định nghĩa
        $this->routes[trim($route, '/')] = $action;
    }

    public function dispatch($uri) 
    {
        $uri = trim($uri, '/');

        if (array_key_exists($uri, $this->routes)) {
            $action = $this->routes[$uri];

            // Kiểm tra loại của action
            if (is_array($action) && count($action) == 2) {
                // Trường hợp action là một mảng [Controller::class, 'method']
                list($controller, $method) = $action;

                if (class_exists($controller) && method_exists($controller, $method)) {
                    $controllerInstance = new $controller();
                    return $controllerInstance->$method();
                } else {
                    echo "Controller or method not found.";
                }
            } else {
                echo "Invalid route action.";
            }
        } else {
            echo "404 Not Found";
        }
    }
}
