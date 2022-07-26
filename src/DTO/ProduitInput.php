<?php

namespace App\DTO;

use Symfony\Component\HttpFoundation\File\File;

class ProduitInput {
    public string $nom;
    public string $prix;
    public File $image;
}
