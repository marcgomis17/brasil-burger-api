<?php

namespace App\Service;

use App\IService\ICalculPrix;

class CalculPrix implements ICalculPrix {
    public function calculPrix($data) {
        $prix = 0;
        foreach ($data->getMenuBurgers() as $menuBurger) {
            $prix += $menuBurger->getQuantite() * $menuBurger->getBurger()->getPrix();
        }
        foreach ($data->getMenuFrites() as $menuFrites) {
            $prix += ($menuFrites->getQuantite() * $menuFrites->getFrites()->getPrix());
        }
        foreach ($data->getMenuTailles() as $menuTaille) {
            $prix += ($menuTaille->getQuantite() * $menuTaille->getTailles()->getPrix());
        }
        return $prix;
    }
}
