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
    input: GestionnaireInput::class,
    output: GestionnaireOutput::class,
    collectionOperations: [
        'get',
        'post'
    ]
)]
class Gestionnaire extends User {
    #[ORM\OneToMany(mappedBy: 'gestionnaire', targetEntity: Produit::class)]
    private $produits;

    public function __construct() {
        $this->setRoles(['ROLE_GESTIONNAIRE']);
        $this->produits = new ArrayCollection();
        $this->setIsVerified(true);
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
