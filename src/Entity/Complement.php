<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ComplementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource(
    itemOperations: [
        'get'
    ]
)]
class Complement {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    private $id;

    private $frites = [];
    private $boissons = [];

    public function getId(): ?int {
        return $this->id;
    }

    public function __construct() {
        $this->id = 1;
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
}
