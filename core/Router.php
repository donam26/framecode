<?php

namespace Core;

class Router {
    protected $routes = [];
    protected $container;

    // Khởi tạo router với Container
    public function __construct(Container $container) {
        $this->container = $container;
    }

    // Thêm route với action
    public function add($route, $action) 
    {
        $this->routes[trim($route, '/')] = $action;
    }

    public function dispatch($uri) 
    {
        // Chuẩn hóa URI
        $uri = trim($uri, '/');

        // Kiểm tra xem URI có tồn tại trong routes không
        if (array_key_exists($uri, $this->routes)) {
            $action = $this->routes[$uri];

            // Kiểm tra nếu $action là một mảng [controller, method]
            if (is_array($action) && count($action) === 2) {
                list($controller, $method) = $action;

                // Kiểm tra nếu controller và method tồn tại
                if (class_exists($controller) && method_exists($controller, $method)) {
                    // Sử dụng container để khởi tạo controller
                    $controllerInstance = $this->container->make($controller);

                    // Kiểm tra controllerInstance có phải là null không
                    if ($controllerInstance === null) {
                        throw new \Exception("Controller instance could not be created.");
                    }

                    // Reflection để lấy danh sách các tham số và inject dependency
                    $reflector = new \ReflectionMethod($controllerInstance, $method);

                    // Kiểm tra method có tồn tại trong controllerInstance không
                    if (!$reflector->isPublic()) {
                        throw new \Exception("Method {$method} is not public or does not exist in controller {$controller}.");
                    }

                    $parameters = $reflector->getParameters();
                    $dependencies = [];

                    foreach ($parameters as $parameter) {
                        // Lấy tên class của các tham số được yêu cầu và inject vào
                        if ($parameter->getType() && !$parameter->getType()->isBuiltin()) {
                            $dependencyClass = $parameter->getType()->getName();

                            // Sử dụng container để giải quyết phụ thuộc
                            $dependencies[] = $this->container->make($dependencyClass);
                        } else {
                            $dependencies[] = null; // Trường hợp không có kiểu dữ liệu được chỉ định
                        }
                    }

                    // Gọi method của controller với các dependencies
                    return call_user_func_array([$controllerInstance, $method], $dependencies);
                } else {
                    echo "Controller or method not found.";
                }
            } else {
                echo "Invalid action format. Expected array [controller, method].";
            }
        } else {
            echo "404 Not Found";
        }
    }
}
