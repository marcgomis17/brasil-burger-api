<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
#[ApiResource(
    collectionOperations: [
        "getAll" => [
            "method" => "get",
            "path" => "/gestionnaire/Menus",
            "status" => Response::HTTP_OK,
            "normalization_context" => ["groups" => ["product:read:gestionnaire"]],
            "security" => "is_granted('ROLE_GESTIONNAIRE')"
        ],
        "getUsers" => [
            "method" => "get",
            "status" => Response::HTTP_OK,
            "normalization_context" => ["groups" => ["product:read:users"]]
        ],
        "post" => [
            "security" => "is_granted('ROLE_GESTIONNAIRE')"
        ]
    ],
    itemOperations: [
        'get',
        "put" => [
            "security" => "is_granted('ROLE_GESTIONNAIRE')"
        ]
    ]
)]
class Menu {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["product:read:users", "product:read:gestionnaire"])]
    private $id;

    #[ORM\Column(type: 'string', length: 60)]
    #[Groups(["product:read:users", "product:read:gestionnaire"])]
    private $nom;

    #[ORM\Column(type: 'integer')]
    #[Groups(["product:read:users", "product:read:gestionnaire"])]
    private $prix;

    #[ORM\Column(type: 'string', length: 30, nullable: true)]
    #[Groups(["product:read:gestionnaire"])]
    private $etat;

    #[ORM\ManyToMany(targetEntity: Burger::class, inversedBy: 'menus')]
    #[Groups(["product:read:users", "product:read:gestionnaire"])]
    private $burgers;

    #[ORM\ManyToMany(targetEntity: Boisson::class, inversedBy: 'menus')]
    #[Groups(["product:read:users", "product:read:gestionnaire"])]
    private $boissons;

    #[ORM\ManyToMany(targetEntity: PortionFrite::class, inversedBy: 'menus')]
    #[Groups(["product:read:users", "product:read:gestionnaire"])]
    private $frites;

    public function __construct() {
        $this->burgers = new ArrayCollection();
        $this->boissons = new ArrayCollection();
        $this->frites = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
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

    public function getEtat(): ?string {
        return $this->etat;
    }

    public function setEtat(string $etat): self {
        $this->etat = $etat;

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
}
