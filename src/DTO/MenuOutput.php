<?php

namespace App\DTO;

use App\Entity\Menu;

final class MenuOutput {
    public int $id;
    public string $nom;
    public int $prix;
    public $image;
    public MenuBurgerOutput $menuBurgers;
    public MenuTailleBoissonOutput $MenuTailles;
    public MenuPortionFriteOutput $menuFrites;

    public function __construct(Menu $menu, MenuBurgerOutput $menuBurger, MenuTailleBoissonOutput $menuTailleBoisson, MenuPortionFriteOutput $menuFrite) {
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
