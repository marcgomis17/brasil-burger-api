<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\GraphQl\Resolver\Stage\WriteStage;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
#[ApiResource(
    collectionOperations: [
        'get' => [
            'method' => 'GET',
            'normalization_context' => ['groups' => ['orders:read']],
        ],
        'post' => [
            'method' => 'POST',
            'security' => "is_granted('ROLE_GESTIONNAIRE')",
            'denormalization_context' => ['groups' => ['orders:write']],
        ]
    ],
    itemOperations: [
        'get',
        'put' => [
            'security' => "is_granted('ROLE_GESTIONNAIRE')",
        ]
    ]
)]
class Commande {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Zone::class, inversedBy: 'commandes')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['orders:write', 'orders:read'])]
    private $zone;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'commandes')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['orders:write', 'orders:read'])]
    private $client;

    #[ORM\ManyToMany(targetEntity: Burger::class, inversedBy: 'commandes')]
    #[Groups(['orders:write', 'orders:read'])]
    private $burgers;

    #[ORM\ManyToMany(targetEntity: Menu::class, inversedBy: 'commandes')]
    #[Groups(['orders:write', 'orders:read'])]
    private $menus;

    public function __construct() {
        $this->produits = new ArrayCollection();
        $this->burgers = new ArrayCollection();
        $this->menus = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getZone(): ?Zone {
        return $this->zone;
    }

    public function setZone(?Zone $zone): self {
        $this->zone = $zone;

        return $this;
    }

    public function getClient(): ?Client {
        return $this->client;
    }

    public function setClient(?Client $client): self {
        $this->client = $client;

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

    public function removeMenu(Menu $menu): self {
        $this->menus->removeElement($menu);

        return $this;
    }
}
