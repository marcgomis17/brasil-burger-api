<?php

namespace App\Entity;

use App\DTO\MenuInput;
use App\DTO\MenuOutput;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
#[ApiResource(
    input: MenuInput::class,
    output: MenuOutput::class,
    collectionOperations: [
        'get',
        'post' => [
            'input_formats' => [
                'multipart' => ['multipart/form-data'],
            ],
            'security' => "is_granted('ROLE_GESTIONNAIRE')",
        ]
    ],
    itemOperations: [
        'get',
        'put' => [
            'security' => "is_granted('ROLE_GESTIONNAIRE')",
        ],
        'patch' => [
            'security' => "is_granted('ROLE_GESTIONNAIRE')",
        ]
    ]
)]
class Menu extends Produit {
    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuBurger::class, cascade: ["persist"])]
    #[Assert\Count(min: 1)]
    private $menuBurgers;

    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuPortionFrite::class, cascade: ["persist"])]
    #[Assert\Count(min: 1)]
    private $menuFrites;

    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuTailleBoisson::class, cascade: ["persist"])]
    #[Assert\Count(min: 1)]
    private $menuTailles;

    #[ORM\ManyToMany(targetEntity: Commande::class, mappedBy: 'menus')]
    private $commandes;

    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuCommande::class)]
    private $menuCommandes;

    public function __construct() {
        $this->commandes = new ArrayCollection();
        $this->menuBurgers = new ArrayCollection();
        $this->menuFrites = new ArrayCollection();
        $this->menuTailles = new ArrayCollection();
        $this->menuCommandes = new ArrayCollection();
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection {
        return $this->commandes;
    }


    public function getGestionnaire(): ?Gestionnaire {
        return $this->gestionnaire;
    }

    public function setGestionnaire(?Gestionnaire $gestionnaire): self {
        $this->gestionnaire = $gestionnaire;

        return $this;
    }

    /**
     * Get the value of menuBurgers
     */
    public function getMenuBurgers() {
        return $this->menuBurgers;
    }

    /**
     * Set the value of menuBurgers
     *
     * @return  self
     */
    public function setMenuBurgers($menuBurgers) {
        $this->menuBurgers = $menuBurgers;

        return $this;
    }

    /**
     * @return Collection<int, MenuPortionFrite>
     */
    public function getMenuFrites(): Collection {
        return $this->menuFrites;
    }

    public function addMenuFrite(MenuPortionFrite $menuFrite): self {
        if (!$this->menuFrites->contains($menuFrite)) {
            $this->menuFrites[] = $menuFrite;
            $menuFrite->setMenu($this);
        }

        return $this;
    }

    public function removeMenuFrite(MenuPortionFrite $menuFrite): self {
        if ($this->menuFrites->removeElement($menuFrite)) {
            // set the owning side to null (unless already changed)
            if ($menuFrite->getMenu() === $this) {
                $menuFrite->setMenu(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MenuTailleBoisson>
     */
    public function getMenuTailles(): Collection {
        return $this->menuTailles;
    }

    public function addMenuTaille(MenuTailleBoisson $menuTaille): self {
        if (!$this->menuTailles->contains($menuTaille)) {
            $this->menuTailles[] = $menuTaille;
            $menuTaille->setMenu($this);
        }

        return $this;
    }

    public function removeMenuTaille(MenuTailleBoisson $menuTaille): self {
        if ($this->menuTailles->removeElement($menuTaille)) {
            // set the owning side to null (unless already changed)
            if ($menuTaille->getMenu() === $this) {
                $menuTaille->setMenu(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MenuCommande>
     */
    public function getMenuCommandes(): Collection {
        return $this->menuCommandes;
    }

    public function addMenuCommande(MenuCommande $menuCommande): self {
        if (!$this->menuCommandes->contains($menuCommande)) {
            $this->menuCommandes[] = $menuCommande;
            $menuCommande->setMenu($this);
        }

        return $this;
    }

    public function removeMenuCommande(MenuCommande $menuCommande): self {
        if ($this->menuCommandes->removeElement($menuCommande)) {
            // set the owning side to null (unless already changed)
            if ($menuCommande->getMenu() === $this) {
                $menuCommande->setMenu(null);
            }
        }

        return $this;
    }
}
