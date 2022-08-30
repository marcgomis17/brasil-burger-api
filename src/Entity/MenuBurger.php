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
    /* input: MenuBurgerInput::class,
    output: MenuBurgerOutput::class, */
    /* collectionOperations: [
        'get' => [
            "normalization_context" => ["groups" => ['menuBurger:read']],
        ],
        'post' => [
            "denormalization_context" => ["groups" => ['menuBurger:write']],
            "normalization_context" => ["groups" => ['menuBurger:read']],
            'input_formats' => [
                'multipart' => ['multipart/form-data'],
            ],
            'security' => "is_granted('ROLE_GESTIONNAIRE')",
        ]
    ],
    itemOperations: [
        'get' => [
            "normalization_context" => ["groups" => ['menuBurger:read']],
        ],
        'put' => [
            "denormalization_context" => ["groups" => ['menuBurger:write']],
            "normalization_context" => ["groups" => ['menuBurger:read']],
            'security' => "is_granted('ROLE_GESTIONNAIRE')"
        ],
        'patch' => [
            "denormalization_context" => ["groups" => ['menuBurger:write']],
            "normalization_context" => ["groups" => ['menuBurger:read']],
            'security' => "is_granted('ROLE_GESTIONNAIRE')",
        ]
    ] */)]
class MenuBurger {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    #[Assert\Positive()]
    #[Groups(['menu:write','menu:read', 'details:read'])]
    private $quantite;

    #[ORM\ManyToOne(targetEntity: Burger::class, inversedBy: 'menuBurgers')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['menu:write','menu:read', 'details:read'])]
    private $burger;

    #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: 'menuBurgers')]
    #[ORM\JoinColumn(nullable: false)]
    private $menu;

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

    public function getBurger(): ?Burger {
        return $this->burger;
    }

    public function setBurger(?Burger $burger): self {
        $this->burger = $burger;

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
