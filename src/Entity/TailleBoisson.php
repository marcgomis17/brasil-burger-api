<?php

namespace App\Entity;

use App\DTO\TailleBoissonInput;
use App\DTO\TailleBoissonOutput;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TailleBoissonRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TailleBoissonRepository::class)]
#[ApiResource(
    /* input: TailleBoissonInput::class,
    output: TailleBoissonOutput::class, */
    collectionOperations: [
        'get' => [
            "normalization_context" => ["groups" => ['taille:read']],
        ],
        'post' => [
            "denormalization_context" => ["groups" => ['taille:write']],
            "normalization_context" => ["groups" => ['taille:read']],
            'security' => "is_granted('ROLE_GESTIONNAIRE')",
        ]
    ],
    itemOperations: [
        'get',
        'put' => [
            'security' => "is_granted('ROLE_GESTIONNAIRE')",
        ],
    ]
)]
class TailleBoisson {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['menu:write', 'menu:read', 'taille:read', 'product:read', 'product:write'])]
    private $id;

    #[ORM\Column(type: 'string', length: 100, unique: true)]
    #[Groups(['taille:write', 'taille:read'])]
    private $libelle;

    #[ORM\Column(type: 'integer')]
    #[Groups(['taille:write', 'taille:read'])]
    private $prix;

    public function __construct() {
        $this->boissons = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getLibelle(): ?string {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self {
        $this->libelle = $libelle;

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
