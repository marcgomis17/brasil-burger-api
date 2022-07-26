<?php

namespace App\Entity;

use App\DTO\BurgerInput;
use App\DTO\BurgerOutput;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BurgerRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: BurgerRepository::class)]
#[ApiResource(
    input: BurgerInput::class,
    output: BurgerOutput::class,
    collectionOperations: [
        'get',
        'post' => [
            'input_formats' => [
                'multipart' => ['multipart/form-data'],
            ]
        ]
    ],
    itemOperations: [
        'get',
        'put' => [
            'input_formats' => [
                'multipart' => ['multipart/form-data'],
            ],
        ],
    ]
)]
class Burger extends Produit {
    #[ORM\ManyToMany(targetEntity: Menu::class, mappedBy: 'burgers')]
    private $menus;

    #[ORM\OneToMany(mappedBy: 'burgers', targetEntity: MenuBurger::class)]
    private $menuBurgers;

    #[ORM\OneToMany(mappedBy: 'burger', targetEntity: BurgerCommande::class)]
    private $burgerCommandes;

    public function __construct() {
        parent::__construct();
        $this->menus = new ArrayCollection();
        $this->menuBurgers = new ArrayCollection();
        $this->burgerCommandes = new ArrayCollection();
    }

    /**
     * @return Collection<int, MenuBurger>
     */
    public function getMenuBurgers(): Collection {
        return $this->menuBurgers;
    }

    public function addMenuBurger(MenuBurger $menuBurger): self {
        if (!$this->menuBurgers->contains($menuBurger)) {
            $this->menuBurgers[] = $menuBurger;
            $menuBurger->setBurgers($this);
        }

        return $this;
    }

    public function removeMenuBurger(MenuBurger $menuBurger): self {
        if ($this->menuBurgers->removeElement($menuBurger)) {
            // set the owning side to null (unless already changed)
            if ($menuBurger->getBurgers() === $this) {
                $menuBurger->setBurgers(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BurgerCommande>
     */
    public function getBurgerCommandes(): Collection {
        return $this->burgerCommandes;
    }

    public function addBurgerCommande(BurgerCommande $burgerCommande): self {
        if (!$this->burgerCommandes->contains($burgerCommande)) {
            $this->burgerCommandes[] = $burgerCommande;
            $burgerCommande->setBurger($this);
        }

        return $this;
    }

    public function removeBurgerCommande(BurgerCommande $burgerCommande): self {
        if ($this->burgerCommandes->removeElement($burgerCommande)) {
            // set the owning side to null (unless already changed)
            if ($burgerCommande->getBurger() === $this) {
                $burgerCommande->setBurger(null);
            }
        }

        return $this;
    }

    /**
     * Get the value of menus
     */
    public function getMenus() {
        return $this->menus;
    }

    /**
     * Set the value of menus
     *
     * @return  self
     */
    public function setMenus($menus) {
        $this->menus = $menus;

        return $this;
    }
}
