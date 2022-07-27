<?php

namespace App\DTO;

use App\Entity\MenuBurger;

final class MenuBurgerInput {
    public int $quantite;
    public BurgerMenuInput $burger;

    public function __construct(BurgerMenuInput $burgerMenuInput) {
        $this->burger = $burgerMenuInput;
    }
}
