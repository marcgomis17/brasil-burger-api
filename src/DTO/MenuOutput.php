<?php

namespace App\DTO;

use App\Entity\Menu;
use App\Entity\MenuBurger;
use App\Entity\MenuPortionFrite;
use App\Entity\MenuTailleBoisson;
use Doctrine\Common\Collections\ArrayCollection;

final class MenuOutput {
    public int $id;
    public string $nom;
    public int $prix;
    public $image;
    public MenuBurgerOutput $menuBurgers;
    public MenuTailleBoisson $MenuTailles;
    public MenuPortionFrite $menuFrites;

    public function __construct(Menu $menu, MenuBurgerInput $menuBurger, MenuTailleBoissonInput $menuTailleBoisson, MenuPortionFriteInput $menuFrite) {
        $this->id = $menu->getId();
        $this->menuBurgers = $menuBurger;
        $this->menuTailles = $menuTailleBoisson;
        $this->menuFrites = $menuFrite;
    }

    public function addMenuBurger(MenuBurgerOutput $menuBurger): self {
        if (!$this->menuBurger->contains($menuBurger)) {
            $this->menuBurger[] = $menuBurger;
        }

        return $this;
    }

    public function addMenuTaille(MenuTailleBoissonOutput $menuTaille): self {
        if (!$this->menuTailles->contains($menuTaille)) {
            $this->menuTailles[] = $menuTaille;
        }

        return $this;
    }

    public function addMenuFrite(MenuPortionFriteOutput $menuFrite): self {
        if (!$this->menuFrite->contains($menuFrite)) {
            $this->menuFrite[] = $menuFrite;
        }

        return $this;
    }
}
