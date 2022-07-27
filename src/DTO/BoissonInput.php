<?php

namespace App\DTO;

use Symfony\Component\HttpFoundation\File\File;

final class BoissonInput {
    public int $id;
    public string $nom;
    public File $image;
}
