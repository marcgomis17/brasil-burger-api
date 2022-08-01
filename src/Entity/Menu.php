<?php

namespace App\Entity;

use App\DTO\MenuInput;
use App\DTO\MenuOutput;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
#[ApiResource(
    /* input: MenuInput::class,
    output: MenuOutput::class, */
    collectionOperations: [
        'get' => [
            "normalization_context" => ["groups" => ['menu:read']],
        ],
        'post' => [
            "denormalization_context" => ["groups" => ['menu:write']],
            "normalization_context" => ["groups" => ['menu:read']],
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
    #[Groups(['menu:read'])]
    public $id;

    #[Groups(['menu:write', 'menu:read'])]
    public $nom;

    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuBurger::class, cascade: ["persist"])]
    #[Assert\Count(min: 1)]
    #[Groups(['menu:write', 'menu:read'])]
    private $menuBurgers;

    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuPortionFrite::class, cascade: ["persist"])]
    #[Assert\Count(min: 1)]
    #[Groups(['menu:write', 'menu:read'])]
    private $menuFrites;

    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuTailleBoisson::class, cascade: ["persist"])]
    #[Assert\Count(min: 1)]
    #[Groups(['menu:write', 'menu:read'])]
    private $menuTailles;

    #[SerializedName('image')]
    #[Groups(['menu:write', 'menu:read'])]
    private ?File $file;

    #[Groups(['menu:read'])]
    protected $image;

    #[ORM\ManyToMany(targetEntity: Commande::class, mappedBy: 'menus')]
    private $commandes;

    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuCommande::class)]
    private $menuCommandes;

    public function __construct() {
        $this->commandes = new ArrayCollection();
        $this->menuBurgers = new ArrayCollection();
        $this->menuFrites = new ArrayCollection();
        $this->menuTailles = new ArrayCollection();
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

    /**
     * @return Collection<int, MenuBurger>
     */
    public function getMenuBurgers(): Collection {
        return $this->menuBurgers;
    }

    public function addMenuBurger(MenuBurger $menuBurger): self {
        if (!$this->menuBurgers->contains($menuBurger)) {
            $this->menuBurgers[] = $menuBurger;
            $menuBurger->setMenu($this);
        }

        return $this;
    }

    public function removeMenuBurger(MenuBurger $menuBurger): self {
        if ($this->menuBurgers->removeElement($menuBurger)) {
            // set the owning side to null (unless already changed)
            if ($menuBurger->getMenu() === $this) {
                $menuBurger->setMenu(null);
            }
        }

        return $this;
    }
}
