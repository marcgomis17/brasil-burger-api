<?php

namespace App\DTO;

final class MenuBurgerOutput {
    public int $id;
    public int $quantite;
    public BurgerMenuIO $burger;

    public function __construct(BurgerMenuIO $burgerMenuOutput) {
        $this->burger = $burgerMenuOutput;
    }
}
