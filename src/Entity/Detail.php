<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    collectionOperations: [],
    itemOperations: [
        'get' => [
            "normalization_context" => ["groups" => ['details:read']]
        ]
    ]
)]
class Detail {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    private $id;

    #[Groups('details:read')]
    private $produit;

    #[Groups('details:read')]
    private $boissons = [];

    #[Groups('details:read')]
    private $frites = [];

    public function getId(): ?int {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id) {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of boissons
     */
    public function getBoissons() {
        return $this->boissons;
    }

    /**
     * Set the value of boissons
     *
     * @return  self
     */
    public function setBoissons($boissons) {
        $this->boissons = $boissons;

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

    /**
     * Get the value of produit
     */
    public function getProduit() {
        return $this->produit;
    }

    /**
     * Set the value of produit
     *
     * @return  self
     */
    public function setProduit($produit) {
        $this->produit = $produit;

        return $this;
    }
}
