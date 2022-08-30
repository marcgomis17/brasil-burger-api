<?php

namespace App\IService;

interface ICalculPrix {
    public function calculPrix($data);
    public function calculPrixCommande($data);
}
