<?php

namespace App\Entity;

use App\Entity\Livreur;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\LivraisonRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: LivraisonRepository::class)]
#[ApiResource(
    collectionOperations: [
        'get' => [
            'method' => 'GET',
            'normalization_context' => ['groups' => ['deliver:read']],
        ],
        'post' => [
            'method' => 'POST',
            'security' => "is_granted('ROLE_GESTIONNAIRE')",
            'denormalization_context' => ['groups' => ['deliver:write']],
            'normalization_context' => ['groups' => ['deliver:read']],
        ]
    ],
    itemOperations: [
        'get',
    ]
)]
class Livraison {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['deliver:read'])]
    private $id;

    #[ORM\ManyToOne(targetEntity: Livreur::class, inversedBy: 'livraisons')]
    #[Groups(['deliver:read', 'deliver:write'])]
    private $livreur;

    #[ORM\ManyToOne(targetEntity: Zone::class, inversedBy: 'livraisons')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['deliver:read', 'deliver:write'])]
    private $zone;

    #[ORM\OneToMany(mappedBy: 'livraison', targetEntity: Commande::class)]
    #[Groups(['deliver:read', 'deliver:write', 'user:read', 'user:write'])]
    private $commandes;

    public function __construct() {
        $this->commandes = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getLivreur(): ?Livreur {
        return $this->livreur;
    }

    public function setLivreur(?Livreur $livreur): self {
        $this->livreur = $livreur;

        return $this;
    }

    public function getZone(): ?Zone {
        return $this->zone;
    }

    public function setZone(?Zone $zone): self {
        $this->zone = $zone;

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->setLivraison($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getLivraison() === $this) {
                $commande->setLivraison(null);
            }
        }

        return $this;
    }
}
