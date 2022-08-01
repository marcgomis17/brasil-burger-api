<?php

namespace App\Service;

use App\IService\ICalculPrix;

class CalculPrix implements ICalculPrix {
    public function calculPrix($data) {
        $prix = 0;
        $menuBurgers = $data->getMenuBurgers();
        $menuFrites = $data->getMenuFrites();
        $menuTailles = $data->getMenuTailles();
        foreach ($menuBurgers as $burger) {
            $prix += $burger->getQuantite() * $burger->getBurger()->getPrix();
        }
        foreach ($menuFrites as $frite) {
            $prix += $frite->getQuantite() * $frite->getFrites()->getPrix();
        }
        foreach ($menuTailles as $taille) {
            $prix += $burger->getQuantite() * $taille->getTaille()->getPrix();
        }
        return $prix;
    }
}
