<?php

namespace App\Service;

use App\IService\IGenerator;

class OrderNumberGenerator implements IGenerator {
    private $numberSet = "124567890";

    public function generateOrderNumber() {
        $orderNumber = "#BB-";
        for ($i = 0; $i < 9; $i++) {
            $orderNumber .= $this->numberSet[rand(0, 8)];
        }
        return $orderNumber;
    }
}
