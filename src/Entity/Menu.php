<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
#[ApiResource(
    collectionOperations: [
        'get' => [
            'method' => 'GET',
            'normalization_context' => ['groups' => ['product:read']],
        ],
        'post' => [
            'method' => 'POST',
            'security' => "is_granted('ROLE_GESTIONNAIRE')",
            'normalization_context' => ['groups' => ['read']],
            'denormalization_context' => ['groups' => ['menu:write']],
        ]
    ],
    itemOperations: [
        'get',
        'put' => [
            'security' => "is_granted('ROLE_GESTIONNAIRE')",
            'normalization_context' => ['groups' => ['read']],
            'denormalization_context' => ['groups' => ['menu:write']],
        ],
        'patch' => [
            'security' => "is_granted('ROLE_GESTIONNAIRE')",
            'normalization_context' => ['groups' => ['read']],
            'denormalization_context' => ['groups' => ['menu:write']],
        ]
    ]
)]
class Menu {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['menu:write', 'read', 'product:read'])]
    private $id;

    #[ORM\Column(type: 'string', length: 100, unique: true)]
    #[Groups(['menu:write', 'read', 'product:read'])]
    private $nom;

    #[ORM\Column(type: 'integer')]
    #[Groups(['menu:write', 'read', 'product:read'])]
    private $prix;

    #[ORM\ManyToMany(targetEntity: Burger::class, inversedBy: 'menus')]
    #[Groups(['menu:write', 'read', 'product:read'])]
    private $burgers;

    #[ORM\ManyToMany(targetEntity: Boisson::class, inversedBy: 'menus')]
    #[Groups(['menu:write', 'read', 'product:read'])]
    private $boissons;

    #[ORM\ManyToMany(targetEntity: PortionFrite::class, inversedBy: 'menus')]
    #[Groups(['menu:write', 'read', 'product:read'])]
    private $frites;

    #[ORM\ManyToOne(targetEntity: Catalogue::class, inversedBy: 'menus')]
    private $catalogue;

    public function __construct() {
        $this->burgers = new ArrayCollection();
        $this->boissons = new ArrayCollection();
        $this->frites = new ArrayCollection();
    }

    /**
     * Get the value of id
     */
    public function getId() {
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

    public function removeBurger(Burger $burger): self {
        $this->burgers->removeElement($burger);

        return $this;
    }

    /**
     * @return Collection<int, Boisson>
     */
    public function getBoissons(): Collection {
        return $this->boissons;
    }

    public function addBoisson(Boisson $boisson): self {
        if (!$this->boissons->contains($boisson)) {
            $this->boissons[] = $boisson;
        }

        return $this;
    }

    public function removeBoisson(Boisson $boisson): self {
        $this->boissons->removeElement($boisson);

        return $this;
    }

    /**
     * @return Collection<int, PortionFrite>
     */
    public function getFrites(): Collection {
        return $this->frites;
    }

    public function addFrite(PortionFrite $frite): self {
        if (!$this->frites->contains($frite)) {
            $this->frites[] = $frite;
        }

        return $this;
    }

    public function removeFrite(PortionFrite $frite): self {
        $this->frites->removeElement($frite);

        return $this;
    }

    public function getCatalogue(): ?Catalogue {
        return $this->catalogue;
    }

    public function setCatalogue(?Catalogue $catalogue): self {
        $this->catalogue = $catalogue;

        return $this;
    }

    public function getNom(): ?string {
        return $this->nom;
    }

    public function setNom(string $nom): self {
        $this->nom = $nom;

        return $this;
    }

    public function getPrix(): ?int {
        return $this->prix;
    }

    public function setPrix(int $prix): self {
        $this->prix = $prix;

        return $this;
    }
}
