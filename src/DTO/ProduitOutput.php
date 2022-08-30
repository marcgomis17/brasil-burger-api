<?php

namespace App\DTO;

use App\Entity\Gestionnaire;

class ProduitOutput {
    public int $id;
    public string $nom;
    public string $prix;
    public string $image;
}
