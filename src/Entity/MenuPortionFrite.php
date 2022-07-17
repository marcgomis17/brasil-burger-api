<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\MenuPortionFriteRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MenuPortionFriteRepository::class)]
#[ApiResource(
    collectionOperations: [
        'get' => [
            'method' => 'GET',
            'normalization_context' => ['groups' => ['menu:frite:read']],
        ],
        'post' => [
            'security' => "is_granted('ROLE_GESTIONNAIRE')",
            'denormalization_context' => ['groups' => ['menu:frite:write']],
            'normalization_context' => ['groups' => ['menu:frite:read:post']],
        ]
    ],
    itemOperations: [
        'get',
        'put' => [
            'security' => "is_granted('ROLE_GESTIONNAIRE')",
            'denormalization_context' => ['groups' => ['menu:frite:write']],
        ],
        'patch' => [
            'security' => "is_granted('ROLE_GESTIONNAIRE')",
            'denormalization_context' => ['groups' => ['menu:frite:write']],
        ]
    ]
)]
class MenuPortionFrite {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['menu:write', 'menu:read', 'menu:read:post'])]
    private $id;

    #[ORM\Column(type: 'integer')]
    #[Assert\Positive()]
    #[Groups(['menu:write', 'menu:read', 'menu:read:post'])]
    private $quantite;

    #[ORM\ManyToOne(targetEntity: PortionFrite::class, inversedBy: 'menuPortionFrites')]
    #[Groups(['menu:write', 'menu:read', 'menu:read:post'])]
    #[Assert\Valid()]
    private $frites;

    #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: 'menuFrites')]
    #[ORM\JoinColumn(nullable: false)]
    private $menu;

    public function __construct() {
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getFrites(): ?PortionFrite {
        return $this->frites;
    }

    public function setFrites(?PortionFrite $frites): self {
        $this->frites = $frites;

        return $this;
    }

    public function getQuantite(): ?int {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self {
        $this->quantite = $quantite;

        return $this;
    }

    public function getMenu(): ?Menu {
        return $this->menu;
    }

    public function setMenu(?Menu $menu): self {
        $this->menu = $menu;

        return $this;
    }
}
