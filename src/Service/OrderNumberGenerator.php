<?php

namespace App\Service;

use App\IService\IGenerator;

class OrderNumberGenerator implements IGenerator {
    private $numberSet = "124567890";

    public function generateOrderNumber() {
        $orderNumber = "#B";
        for ($i = 0; $i < 6; $i++) {
            $orderNumber .= $this->numberSet[rand(0, 8)];
            if ($i === 2) {
                $orderNumber .= "-";
            }
        }
        echo $orderNumber;
        return $orderNumber;
    }
}
