<?php

namespace App\DTO;

final class MenuTailleBoissonInput {
    public int $quantite;
    public TailleBoissonMenuInput $taille;

    public function __construct(TailleBoissonMenuInput $taille) {
        $this->taille = $taille;
    }
}
