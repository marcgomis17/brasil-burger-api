<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BoissonTailleCommandeRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: BoissonTailleCommandeRepository::class)]
#[ApiResource()]
class BoissonTailleCommande {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    #[Groups(['order:write', 'order:read'])]
    #[Assert\Positive()]
    private $quantite;

    #[ORM\ManyToOne(targetEntity: BoissonTaille::class, inversedBy: 'boissonTailleCommandes')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['order:write', 'order:read'])]
    #[SerializedName('boisson')]
    private $boissonTaille;

    #[ORM\ManyToOne(targetEntity: Commande::class, inversedBy: 'boissonTailleCommandes')]
    private $commande;

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

    public function getCommande(): ?Commande {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): self {
        $this->commande = $commande;

        return $this;
    }

    public function getBoissonTaille(): ?BoissonTaille {
        return $this->boissonTaille;
    }

    public function setBoissonTaille(?BoissonTaille $boissonTaille): self {
        $this->boissonTaille = $boissonTaille;

        return $this;
    }
}
