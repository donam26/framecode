<?php

use Core\Router;
use Core\Container;
use App\Http\Controllers\PaymentController;
use App\Services\PaymentInterface;
use App\Services\CashPayment;

// Khởi tạo container

$container = new Core\Container();

// Bind PaymentInterface với CashPayment
$container->bind(App\Services\PaymentInterface::class, function() {
    return new App\Services\CashPayment();
});

// Khởi tạo router với container
$router = new Core\Router($container);

// Định nghĩa route
$router->add('/payment/process', [PaymentController::class, 'store']);

// Lấy URI hiện tại
$uri = $_SERVER['REQUEST_URI'] ?? '/';

// Gọi router để dispatch route
$router->dispatch($uri);
