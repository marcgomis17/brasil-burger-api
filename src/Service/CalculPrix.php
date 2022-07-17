<?php

namespace App\Service;

use App\IService\ICalculPrix;

class CalculPrix implements ICalculPrix {
    public function calculPrix($data) {
        $prix = 0;
        // dd($data);
        $menuBurgers = $data->getMenuBurgers();
        $menuFrites = $data->getMenuFrites();
        $menuTailles = $data->getMenuTailles();
        foreach ($menuBurgers as $burger) {
            $prix += $burger->getQuantite() * $burger->getBurgers()->getPrix();
        }
        foreach ($menuFrites as $frite) {
            $prix += $frite->getFrites()->getPrix();
        }
        foreach ($menuTailles as $taille) {
            $prix += $taille->getTailles()->getPrix();
        }
        return $prix;
    }
}
