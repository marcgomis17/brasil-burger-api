<?php

namespace App\DTO;

use App\Entity\MenuBurger;

final class MenuBurgerInput {
    public int $quantite;
    public BurgerMenuIO $burger;

    public function __construct(BurgerMenuIO $burgerMenuInput) {
        $this->burger = $burgerMenuInput;
    }
}
