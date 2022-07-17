<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PortionFriteRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PortionFriteRepository::class)]
#[ApiResource(
    collectionOperations: [
        'get' => [
            'normalization_context' => ['groups' => ['product:read']],
        ],
        'post' => [
            'input_formats' => [
                'multipart' => ['multipart/form-data'],
            ],
            'denormalization_context' => ['groups' => ['product:write']]
        ]
    ],
    itemOperations: [
        'get',
        'put' => [
            'security' => "is_granted('ROLE_GESTIONNAIRE')",
            'denormalization_context' => ['groups' => ['product:write']],
        ],
        'patch' => [
            'security' => "is_granted('ROLE_GESTIONNAIRE')",
            'denormalization_context' => ['groups' => ['product:write']],
        ]
    ]
)]
class PortionFrite extends Produit {
    #[ORM\Column(type: 'string', length: 70)]
    #[Groups(['product:read', 'product:write', 'menu:read:post'])]
    private $portion;

    #[ORM\OneToMany(mappedBy: 'frites', targetEntity: MenuPortionFrite::class)]
    private $menuPortionFrites;

    #[ORM\OneToMany(mappedBy: 'frite', targetEntity: PortionFriteCommande::class)]
    private $portionFriteCommandes;

    public function __construct() {
        parent::__construct();
        $this->menus = new ArrayCollection();
        $this->menuPortionFrites = new ArrayCollection();
        $this->portionFriteCommandes = new ArrayCollection();
    }

    /**
     * Get the value of portion
     */
    public function getPortion() {
        return $this->portion;
    }

    /**
     * Set the value of portion
     *
     * @return  self
     */
    public function setPortion($portion) {
        $this->portion = $portion;

        return $this;
    }

    /**
     * @return Collection<int, MenuPortionFrite>
     */
    public function getMenuPortionFrites(): Collection {
        return $this->menuPortionFrites;
    }

    public function addMenuPortionFrite(MenuPortionFrite $menuPortionFrite): self {
        if (!$this->menuPortionFrites->contains($menuPortionFrite)) {
            $this->menuPortionFrites[] = $menuPortionFrite;
            $menuPortionFrite->setFrites($this);
        }

        return $this;
    }

    public function removeMenuPortionFrite(MenuPortionFrite $menuPortionFrite): self {
        if ($this->menuPortionFrites->removeElement($menuPortionFrite)) {
            // set the owning side to null (unless already changed)
            if ($menuPortionFrite->getFrites() === $this) {
                $menuPortionFrite->setFrites(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PortionFriteCommande>
     */
    public function getPortionFriteCommandes(): Collection
    {
        return $this->portionFriteCommandes;
    }

    public function addPortionFriteCommande(PortionFriteCommande $portionFriteCommande): self
    {
        if (!$this->portionFriteCommandes->contains($portionFriteCommande)) {
            $this->portionFriteCommandes[] = $portionFriteCommande;
            $portionFriteCommande->setFrite($this);
        }

        return $this;
    }

    public function removePortionFriteCommande(PortionFriteCommande $portionFriteCommande): self
    {
        if ($this->portionFriteCommandes->removeElement($portionFriteCommande)) {
            // set the owning side to null (unless already changed)
            if ($portionFriteCommande->getFrite() === $this) {
                $portionFriteCommande->setFrite(null);
            }
        }

        return $this;
    }
}
