<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ComplementRepository;
use ApiPlatform\Core\Annotation\ApiResource;

#[ORM\Entity(repositoryClass: ComplementRepository::class)]
#[ApiResource(
    collectionOperations: [
        "get",
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
class Complement {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: PortionFrite::class, inversedBy: 'complements')]
    private $frites;

    #[ORM\ManyToOne(targetEntity: Boisson::class, inversedBy: 'complements')]
    private $boisson;

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

    public function getBoisson(): ?Boisson {
        return $this->boisson;
    }

    public function setBoisson(?Boisson $boisson): self {
        $this->boisson = $boisson;

        return $this;
    }
}
