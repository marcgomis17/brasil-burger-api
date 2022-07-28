<?php

namespace App\Entity;

use App\Entity\PortionFrite;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PortionFriteCommandeRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PortionFriteCommandeRepository::class)]
#[ApiResource()]
class PortionFriteCommande {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    #[Groups(['orders:write', 'orders:read', 'orders:read:post'])]
    #[Assert\Positive()]
    private $quantite;

    #[ORM\ManyToOne(targetEntity: PortionFrite::class, inversedBy: 'portionFriteCommandes')]
    #[Groups(['orders:write', 'orders:read', 'orders:read:post'])]
    private $frite;

    #[ORM\ManyToOne(targetEntity: Commande::class, inversedBy: 'friteCommandes')]
    #[ORM\JoinColumn(nullable: false)]
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

    public function getFrite(): ?PortionFrite {
        return $this->frite;
    }

    public function setFrite(?PortionFrite $frite): self {
        $this->frite = $frite;

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
