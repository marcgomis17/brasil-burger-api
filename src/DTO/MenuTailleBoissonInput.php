<?php

namespace App\DTO;

use App\DTO\TailleBoissonMenuIO;

final class MenuTailleBoissonInput {
    public int $quantite;
    public TailleBoissonMenuIO $taille;

    public function __construct(TailleBoissonMenuIO $taille) {
        $this->taille = $taille;
    }
}
