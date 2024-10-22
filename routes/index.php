<?php 
use Core\Request;
use Core\Router;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;

// Khởi tạo router
$router = new Router();

// Định nghĩa route
$router->add('/', [HomeController::class, 'index']);
$router->add('/home', [HomeController::class, 'home']);
$router->add('/users', [UserController::class, 'index']);

// Lấy URI hiện tại
$uri = Request::uri();

// Gọi router để dispatch route
$router->dispatch($uri);
