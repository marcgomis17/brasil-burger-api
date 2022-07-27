<?php

namespace App\DTO;

final class MenuTailleBoissonOutput {
    public int $id;
    public int $quantite;
    public TailleBoissonMenuOutput $taille;

    public function __construct(TailleBoissonMenuOutput $taille) {
        $this->taille = $taille;
    }
}
