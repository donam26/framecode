<?php 

namespace App\Services;

class CashPayment implements PaymentInterface {
    public function process() {
        return "Thanh toán tiền mặt ";
    }
}