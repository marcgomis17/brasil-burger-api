<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\DTO\MenuTailleBoissonInput;
use App\DTO\MenuTailleBoissonOutput;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\MenuTailleBoissonRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MenuTailleBoissonRepository::class)]
#[ApiResource(
    /* input: MenuTailleBoissonInput::class,
    output: MenuTailleBoissonOutput::class, */
    collectionOperations: [
        'get',
        'post' => [
            'security' => "is_granted('ROLE_GESTIONNAIRE')"
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
class MenuTailleBoisson {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    #[Assert\Positive()]
    #[Groups(['menu:write', 'menu:read'])]
    private $quantite;

    #[ORM\ManyToOne(targetEntity: TailleBoisson::class, inversedBy: 'menuTailleBoissons')]
    #[Assert\Valid()]
    #[Groups(['menu:write', 'menu:read'])]
    private $tailles;

    #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: 'menuTailles')]
    #[ORM\JoinColumn(nullable: false)]
    private $menu;

    public function __construct() {
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getTailles(): ?TailleBoisson {
        return $this->tailles;
    }

    public function setTailles(?TailleBoisson $tailles): self {
        $this->tailles = $tailles;

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
