<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource(
    collectionOperations: [],
    itemOperations: [
        'get'
    ]
)]
class Catalogue {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    private $id;

    private $burgers = [];
    private $menus = [];


    public function __construct() {
        $this->id = 1;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getBurgers(): ?array {
        return $this->burgers;
    }

    public function setBurgers(?array $burgers): self {
        $this->burgers = $burgers;

        return $this;
    }

    public function getMenus(): ?array {
        return $this->menus;
    }

    public function setMenus(?array $menus): self {
        $this->menus = $menus;

        return $this;
    }
}
