<?php

namespace App\Service;

use App\Entity\BurgerCommande;
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

    public function calculPrixCommande($data) {
        $prixCommande = 0;
        $burgerCommandes = $data->getBurgerCommandes();
        $menuCommandes = $data->getMenuCommandes();
        $portionFriteCommandes = $data->getPortionFriteCommande();
        $boissonTailleCommandes = $data->getBoissonTailleCommandes();
        foreach ($burgerCommandes as $burgerCommande) {
            $prixCommande += $burgerCommande->getQuantite() * $burgerCommande->getBurger()->getPrix();
        }
        foreach ($menuCommandes as $menuCommande) {
            $prixCommande += $menuCommande->getQuantite() * $menuCommande->getMenu()->getPrix();
        }
        foreach ($portionFriteCommandes as $portionFriteCommande) {
            $prixCommande += $portionFriteCommande->getQuantite() * $portionFriteCommande->getFrite()->getPrix();
        }
        foreach ($boissonTailleCommandes as $boissonTailleCommande) {
            $prixCommande += $boissonTailleCommande->getQuantite() * $boissonTailleCommande->getBoissonTaille()->getTaille()->getPrix();
        }
        return $prixCommande;
    }
}
