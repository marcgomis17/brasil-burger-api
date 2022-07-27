<?php

namespace App\Entity;

use App\DTO\MenuBurgerInput;
use App\DTO\MenuBurgerOutput;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuBurgerRepository;
use ApiPlatform\Core\Annotation\ApiResource;
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
    private $id;

    #[ORM\Column(type: 'integer')]
    #[Assert\Positive()]
    private $quantite;

    #[ORM\ManyToOne(targetEntity: Burger::class, inversedBy: 'menuBurgers')]
    #[ORM\JoinColumn(nullable: false)]
    private $burger;

    public function getId(): ?int {
        return $this->id;
    }

    public function getQuantite(): ?int {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self {
        $this->quantite = $quantite;

        return $this;
    }

    public function getBurger(): ?Burger
    {
        return $this->burger;
    }

    public function setBurger(?Burger $burger): self
    {
        $this->burger = $burger;

        return $this;
    }
}
