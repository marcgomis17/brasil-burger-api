<?php

namespace App\Entity;

use App\DTO\GestionnaireInput;
use App\DTO\GestionnaireOutput;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\GestionnaireRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: GestionnaireRepository::class)]
#[ApiResource(
    /* input: GestionnaireInput::class,
    output: GestionnaireOutput::class, */
    collectionOperations: [
        'get' => [
            "normalization_context" => ["groups" => ['user:read']]
        ],
        'post' => [
            "denormalization_context" => ["groups" => ['user:write']],
            "normalization_context" => ["groups" => ['user:read']]
        ]
    ],
    itemOperations: [
        'get' => [
            "normalization_context" => ["groups" => ['user:read']]
        ],
        'put' => [
            "denormalization_context" => ["groups" => ['user:write']],
            "normalization_context" => ["groups" => ['user:read']]
        ],
        'patch' => [
            "denormalization_context" => ["groups" => ['user:write']],
            "normalization_context" => ["groups" => ['user:read']]
        ]
    ]
)]
class Gestionnaire extends User {
    #[ORM\OneToMany(mappedBy: 'gestionnaire', targetEntity: Produit::class)]
    private $produits;

    public function __construct() {
        $this->setRoles(['ROLE_GESTIONNAIRE']);
        $this->setIsVerified(true);
        $this->produits = new ArrayCollection();
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
            $produit->setGestionnaire($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self {
        if ($this->produits->removeElement($produit)) {
            // set the owning side to null (unless already changed)
            if ($produit->getGestionnaire() === $this) {
                $produit->setGestionnaire(null);
            }
        }

        return $this;
    }
}
