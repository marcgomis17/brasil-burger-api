<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;

// #[ORM\Entity()]
#[ApiResource(
    collectionOperations: [
        'get'
    ]
)]
class Catalogue {
    private $burgers;
    private $menus;

    public function __construct() {
        $this->burgers = new ArrayCollection();
        $this->menus = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    /**
     * @return Collection<int, Burger>
     */
    public function getBurgers(): Collection {
        return $this->burgers;
    }

    public function addBurger(Burger $burger): self {
        if (!$this->burgers->contains($burger)) {
            $this->burgers[] = $burger;
        }

        return $this;
    }

    /**
     * @return Collection<int, Menu>
     */
    public function getMenus(): Collection {
        return $this->menus;
    }

    public function addMenu(Menu $menu): self {
        if (!$this->menus->contains($menu)) {
            $this->menus[] = $menu;
        }

        return $this;
    }
}
