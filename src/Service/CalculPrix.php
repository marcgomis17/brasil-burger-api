<?php

namespace App\Service;

use App\IService\ICalculPrix;

class CalculPrix implements ICalculPrix {
    public function calculPrix($data) {
        $prix = 0;
        $menuBurgers = $data->getMenuBurgers();
        $frites = $data->getFrites();
        $boissons = $data->getTailles();
        foreach ($menuBurgers as $burger) {
            $prix += $burger->getQuantite() * $burger->getBurgers()->getPrix();
        }
        foreach ($frites as $frite) {
            $prix += $frite->getPrix();
        }
        foreach ($boissons as $boisson) {
            $prix += $boisson->getPrix();
        }
        return $prix;
    }
}
