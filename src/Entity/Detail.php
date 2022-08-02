<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\DetailRepository;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource(
    collectionOperations: [],
    itemOperations: [
        'get'
    ]
)]
class Detail {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    private $id;

    private $produit;
    private $boissons = [];
    private $frites = [];

    public function __construct() {
    }

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
