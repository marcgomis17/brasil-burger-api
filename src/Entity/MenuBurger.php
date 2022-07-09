<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuBurgerRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MenuBurgerRepository::class)]
#[ApiResource(
    collectionOperations: [
        'get' => [
            'method' => 'GET',
            'normalization_context' => ['groups' => ['menu:burger:read']],
        ],
        'post' => [
            'security' => "is_granted('ROLE_GESTIONNAIRE')",
            'denormalization_context' => ['groups' => ['menu:burger:write']],
            'normalization_context' => ['groups' => ['menu:burger:read:post']],
        ]
    ],
    itemOperations: [
        'get',
        'put' => [
            'security' => "is_granted('ROLE_GESTIONNAIRE')",
            'denormalization_context' => ['groups' => ['menu:burger:write']],
        ],
        'patch' => [
            'security' => "is_granted('ROLE_GESTIONNAIRE')",
            'denormalization_context' => ['groups' => ['menu:burger:write']],
        ]
    ]
)]
class MenuBurger {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['menu:write', 'menu:read', 'menu:read:post'])]
    private $id;

    #[ORM\Column(type: 'integer')]
    #[Groups(['menu:write', 'menu:read', 'menu:read:post', 'menu:burger:read', 'menu:burger:read:post', 'menu:burger:write'])]
    #[Assert\Positive()]
    private $quantite;

    #[ORM\ManyToOne(targetEntity: Burger::class, inversedBy: 'menuBurgers')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['menu:write', 'menu:read', 'menu:read:post', 'menu:burger:read', 'menu:burger:read:post', 'menu:burger:write'])]
    #[Assert\Valid()]
    private $burgers;

    public function getId(): ?int {
        return $this->id;
    }

    public function getBurgers(): ?Burger {
        return $this->burgers;
    }

    public function setBurgers(?Burger $burgers): self {
        $this->burgers = $burgers;

        return $this;
    }

    public function getQuantite(): ?int {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self {
        $this->quantite = $quantite;

        return $this;
    }
}
