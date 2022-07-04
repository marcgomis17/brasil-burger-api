<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GestionnaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GestionnaireRepository::class)]
#[ApiResource(
    collectionOperations: [
        'get' => [
            'normalization_context' => ['groups' => ['users:read']],
        ],
        'post' => [
            'denormalization_context' => ['groups' => ['users:write']],
            'normalization_context' => ['groups' => ['users:read:post']]

        ]
    ]
)]
class Gestionnaire extends User {
    #[ORM\OneToMany(mappedBy: 'gestionnaire', targetEntity: Produit::class)]
    private $produits;

    #[ORM\OneToMany(mappedBy: 'gestionnaire', targetEntity: Menu::class)]
    private $menus;

    public function __construct() {
        $this->setRoles(['ROLE_GESTIONNAIRE']);
        $this->produits = new ArrayCollection();
        $this->menus = new ArrayCollection();
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

    /**
     * @return Collection<int, Menu>
     */
    public function getMenus(): Collection {
        return $this->menus;
    }

    public function addMenu(Menu $menu): self {
        if (!$this->menus->contains($menu)) {
            $this->menus[] = $menu;
            $menu->setGestionnaire($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self {
        if ($this->menus->removeElement($menu)) {
            // set the owning side to null (unless already changed)
            if ($menu->getGestionnaire() === $this) {
                $menu->setGestionnaire(null);
            }
        }

        return $this;
    }
}
