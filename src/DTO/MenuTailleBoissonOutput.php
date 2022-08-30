<?php

namespace App\DTO;

final class MenuTailleBoissonOutput {
    public int $id;
    public int $quantite;
    public TailleBoissonMenuIO $taille;

    public function __construct(TailleBoissonMenuIO $taille) {
        $this->taille = $taille;
    }
}
