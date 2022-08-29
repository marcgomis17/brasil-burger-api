<?php

namespace App\Entity;

use App\DTO\PortionFriteInput;
use App\DTO\PortionFriteOutput;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PortionFriteRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PortionFriteRepository::class)]
#[ApiResource(
    /* input: PortionFriteInput::class,
    output: PortionFriteOutput::class, */
    collectionOperations: [
        'get' => [
            "normalization_context" => ["groups" => ['product:read']],
        ],
        'post' => [
            "denormalization_context" => ["groups" => ['product:write']],
            "normalization_context" => ["groups" => ['product:read']],
            'input_formats' => [
                'multipart' => ['multipart/form-data'],
            ],
            'security' => "is_granted('ROLE_GESTIONNAIRE')",
        ]
    ],
    itemOperations: [
        'get',
        'put' => [
            'input_formats' => [
                'multipart' => ['multipart/form-data'],
            ],
            'security' => "is_granted('ROLE_GESTIONNAIRE')",
        ],
    ]
)]
class PortionFrite extends Produit {
    #[ORM\Column(type: 'string', length: 70)]
    #[Groups(['product:write', 'product:read', 'menu:add:read'])]
    private $portion;

    #[ORM\OneToMany(mappedBy: 'frites', targetEntity: MenuPortionFrite::class)]
    private $menuPortionFrites;

    #[ORM\OneToMany(mappedBy: 'frite', targetEntity: PortionFriteCommande::class)]
    private $portionFriteCommandes;

    public function __construct() {
        $this->menus = new ArrayCollection();
        $this->menuPortionFrites = new ArrayCollection();
        $this->portionFriteCommandes = new ArrayCollection();
        $this->setType('frite');
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
    public function getPortionFriteCommandes(): Collection {
        return $this->portionFriteCommandes;
    }

    public function addPortionFriteCommande(PortionFriteCommande $portionFriteCommande): self {
        if (!$this->portionFriteCommandes->contains($portionFriteCommande)) {
            $this->portionFriteCommandes[] = $portionFriteCommande;
            $portionFriteCommande->setFrite($this);
        }

        return $this;
    }

    public function removePortionFriteCommande(PortionFriteCommande $portionFriteCommande): self {
        if ($this->portionFriteCommandes->removeElement($portionFriteCommande)) {
            // set the owning side to null (unless already changed)
            if ($portionFriteCommande->getFrite() === $this) {
                $portionFriteCommande->setFrite(null);
            }
        }

        return $this;
    }
}
