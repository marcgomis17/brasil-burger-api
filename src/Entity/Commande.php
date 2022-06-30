<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
#[ApiResource()]
class Commande {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToMany(targetEntity: Produit::class, inversedBy: 'commandes')]
    private $produits;

    #[ORM\ManyToOne(targetEntity: Zone::class, inversedBy: 'commandes')]
    #[ORM\JoinColumn(nullable: false)]
    private $zone;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'commandes')]
    #[ORM\JoinColumn(nullable: false)]
    private $client;

    public function __construct() {
        $this->produits = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    /**
     * @return Collection<int, Produit>
     */
    public function getProduits(): Collection {
        return $this->produits;
    }

    public function addProduit(Produit $produit): self {
        if (!$this->produits->contains($produit)) {
            $this->produits[] = $produit;
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self {
        $this->produits->removeElement($produit);

        return $this;
    }

    public function getZone(): ?Zone {
        return $this->zone;
    }

    public function setZone(?Zone $zone): self {
        $this->zone = $zone;

        return $this;
    }

    public function getClient(): ?Client {
        return $this->client;
    }

    public function setClient(?Client $client): self {
        $this->client = $client;

        return $this;
    }
}
