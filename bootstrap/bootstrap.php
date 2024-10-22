<?php

use App\Services\PaymentInterface;
use Core\Container;

$container = new Container();

$container->bind(PaymentInterface::class, function ($container) {
    return new CashPayment(); 
});