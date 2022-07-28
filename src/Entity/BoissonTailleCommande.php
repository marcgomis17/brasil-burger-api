<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BoissonTailleCommandeRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BoissonTailleCommandeRepository::class)]
#[ApiResource()]
class BoissonTailleCommande {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['orders:write', 'orders:read'])]
    private $id;

    #[ORM\ManyToOne(targetEntity: BoissonTaille::class, inversedBy: 'boissonTailleCommandes', cascade: ["persist"])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['orders:write', 'orders:read', 'orders:read:post'])]
    private $boissonTaille;

    #[ORM\ManyToOne(targetEntity: Commande::class, inversedBy: 'boissonTailleCommandes')]
    #[ORM\JoinColumn(nullable: false)]
    private $commande;

    public function __construct() {
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getBoissonTaille(): ?BoissonTaille {
        return $this->boissonTaille;
    }

    public function setBoissonTaille(?BoissonTaille $boissonTaille): self {
        $this->boissonTaille = $boissonTaille;

        return $this;
    }

    public function getCommande(): ?Commande {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): self {
        $this->commande = $commande;

        return $this;
    }
}
