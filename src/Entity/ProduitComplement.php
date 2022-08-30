<?php

namespace App\Entity;

use App\Entity\Burger;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProduitComplementRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProduitComplementRepository::class)]
#[ApiResource(
    collectionOperations: [],
    itemOperations: [
        'get' => [
            "normalization_context" => ["groups" => ['menu:add:read']]
        ]
    ]
)]
class ProduitComplement {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Groups('menu:add:read')]
    private $burgers = [];

    #[Groups('menu:add:read')]
    private $tailles = [];

    #[Groups('menu:add:read')]
    private $frites = [];

    public function getId(): ?int {
        return $this->id;
    }

    public function __construct() {
        $this->id = 1;
    }
    /**
     * Get the value of burgers
     */
    public function getBurgers() {
        return $this->burgers;
    }

    /**
     * Set the value of burgers
     *
     * @return  self
     */
    public function setBurgers($burgers) {
        $this->burgers = $burgers;

        return $this;
    }

    /**
     * Get the value of tailles
     */
    public function getTailles() {
        return $this->tailles;
    }

    /**
     * Set the value of tailles
     *
     * @return  self
     */
    public function setTailles($tailles) {
        $this->tailles = $tailles;

        return $this;
    }

    /**
     * Get the value of frites
     */
    public function getFrites() {
        return $this->frites;
    }

    /**
     * Set the value of frites
     *
     * @return  self
     */
    public function setFrites($frites) {
        $this->frites = $frites;

        return $this;
    }
}
