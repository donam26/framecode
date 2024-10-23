<?php

namespace App\Http\Controllers;

use App\Services\PaymentInterface;

class PaymentController {
    protected $payment;

    // Inject PaymentInterface vào constructor
    public function __construct(PaymentInterface $payment) {
        $this->payment = $payment;
    }

    public function store() {
        echo $this->payment->process();
    }
}
