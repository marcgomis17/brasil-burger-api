<?php

namespace App\DTO;

use Symfony\Component\HttpFoundation\File\File;

final class MenuInput {
    public string $nom;
    public File $image;
    public MenuBurgerInput $menuBurgers;
    public MenuTailleBoissonInput $menuTailles;
    public MenuPortionFriteInput $menuFrites;

    public function __construct(MenuBurgerInput $menuBurger, MenuTailleBoissonInput $menuTailleBoisson, MenuPortionFriteInput $menuFrite) {
        $this->menuBurgers = $menuBurger;
        $this->menuTailles = $menuTailleBoisson;
        $this->menuFrites = $menuFrite;
        $menuBurger = [$this->menuBurger];
        $menuTailleBoisson = [$this->menuTailles];
        $menuFrite = [$this->menuFrites];
    }

    public function addMenuBurger(MenuBurgerInput $menuBurger): self {
        if (!$this->menuBurger->contains($menuBurger)) {
            $this->menuBurger[] = $menuBurger;
        }

        return $this;
    }

    public function addMenuTaille(MenuTailleBoissonInput $menuTaille): self {
        if (!$this->menuTaille->contains($menuTaille)) {
            $this->menuTaille[] = $menuTaille;
        }

        return $this;
    }

    public function addMenuFrite(MenuPortionFriteInput $menuFrite): self {
        if (!$this->menuFrite->contains($menuFrite)) {
            $this->menuFrite[] = $menuFrite;
        }

        return $this;
    }
}
