<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\QuartierRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: QuartierRepository::class)]
#[ApiResource(
    collectionOperations: [
        'get' => [
            'normalization_context' => ['groups' => ['quartier:read']],
        ],
        'post' => [
            'security' => "is_granted('ROLE_GESTIONNAIRE')",
            'denormalization_context' => ['groups' => ['quartier:write']],
            'normalization_context' => ['groups' => ['quartier:read:post']],
        ]
    ],
    itemOperations: [
        'get',
        'put' => [
            'security' => "is_granted('ROLE_GESTIONNAIRE')",
            'denormalization_context' => ['groups' => ['quartier:write']],
        ],
        'patch' => [
            'security' => "is_granted('ROLE_GESTIONNAIRE')",
            'denormalization_context' => ['groups' => ['quartier:write']],
        ]
    ]
)]
class Quartier {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['quartier:read', 'quartier:read:post', 'zone:write', 'zone:read', 'zone:read:post'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['quartier:write', 'quartier:read', 'quartier:read:post', 'zone:read', 'zone:read:post'])]
    private $nom;

    #[ORM\ManyToOne(targetEntity: Zone::class, inversedBy: 'quartiers')]
    #[Groups(['quartier:write', 'quartier:read'])]
    private $zone;

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

    public function getZone(): ?Zone {
        return $this->zone;
    }

    public function setZone(?Zone $zone): self {
        $this->zone = $zone;

        return $this;
    }
}
