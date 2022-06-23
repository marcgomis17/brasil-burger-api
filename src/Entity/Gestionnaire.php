<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GestionnaireRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GestionnaireRepository::class)]
#[ApiResource()]
class Gestionnaire extends User {
    public function __construct() {
        $this->setRoles(['ROLE_GESTIONNAIRE']);
    }
}
