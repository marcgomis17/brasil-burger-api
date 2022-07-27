<?php

namespace App\Entity;

use App\DTO\MenuBurgerInput;
use App\DTO\MenuBurgerOutput;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuBurgerRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MenuBurgerRepository::class)]
#[ApiResource(
    input: MenuBurgerInput::class,
    output: MenuBurgerOutput::class,
    collectionOperations: [
        'get',
        'post' => [
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
class MenuBurger {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['menu:write', 'menu:read', 'menu:read:post'])]
    private $id;

    #[ORM\Column(type: 'integer')]
    #[Assert\Positive()]
    #[Groups(['menu:write', 'menu:read', 'menu:read:post'])]
    private $quantite;

    #[ORM\ManyToOne(targetEntity: Burger::class, inversedBy: 'menuBurgers')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\Valid()]
    #[Groups(['menu:write', 'menu:read', 'menu:read:post'])]
    private $burger;

    public function getId(): ?int {
        return $this->id;
    }

    public function getBurger(): ?Burger {
        return $this->burger;
    }

    public function setBurger(?Burger $burger): self {
        $this->burger = $burger;

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
