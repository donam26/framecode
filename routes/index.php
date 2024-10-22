<?php 
use Core\Request;
use Core\Router;
use App\Http\Controllers\HomeController;

// Khởi tạo router
$router = new Router();

// Định nghĩa route
$router->add('/', [HomeController::class, 'index']);
$router->add('/home', [HomeController::class, 'home']);

// Lấy URI hiện tại
$uri = Request::uri();

// Gọi router để dispatch route
$router->dispatch($uri);
