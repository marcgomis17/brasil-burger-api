<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ClientRepository;
use ApiPlatform\Core\Annotation\ApiResource;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
#[ApiResource()]
class Client extends User {
    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private $adresse;

    #[ORM\Column(type: 'string', length: 30, nullable: true)]
    private $telephone;

    public function __construct() {
        $this->setRoles(['ROLE_CLIENT']);
        $this->setIsVerified(false);
    }

    public function getAdresse(): ?string {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTelephone(): ?string {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self {
        $this->telephone = $telephone;

        return $this;
    }
}
