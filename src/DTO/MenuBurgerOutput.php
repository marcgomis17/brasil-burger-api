<?php

namespace App\DTO;

final class MenuBurgerOutput {
    public int $id;
    public int $quantite;
    public BurgerMenuOutput $burger;

    public function __construct(BurgerMenuOutput $burgerMenuOutput) {
        $this->burger = $burgerMenuOutput;
    }
}
