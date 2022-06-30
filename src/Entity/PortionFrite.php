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
        'getAll' => [
            'method' => 'GET',
            'path' => '/gestionnaire/portion_frite',
            'normalization_context' => ['groups' => ['product:read:gestionnaire']],
            'security' => "is_granted('ROLE_GESTIONNAIRE')"
        ],
        'get' => [
            'method' => 'GET',
            'normalization_context' => ['groups' => ['product:read:user']],
        ],
        'post' => [
            'method' => 'POST',
            'security' => "is_granted('ROLE_GESTIONNAIRE')",
            'denormalization_context' => ['groups' => ['product:write']],
        ]
    ]
)]
class PortionFrite extends Produit {
    #[ORM\Column(type: 'string', length: 70)]
    #[Groups(['product:write', 'product:read:gestionnaire', 'product:read:user'])]
    private $portion;

    #[ORM\ManyToMany(targetEntity: Menu::class, mappedBy: 'frites')]
    #[Groups(['product:read:gestionnaire', 'product:read:user'])]
    private $menus;

    public function __construct() {
        parent::__construct();
        $this->menus = new ArrayCollection();
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
     * @return Collection<int, Menu>
     */
    public function getMenus(): Collection {
        return $this->menus;
    }

    public function addMenu(Menu $menu): self {
        if (!$this->menus->contains($menu)) {
            $this->menus[] = $menu;
            $menu->addFrite($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self {
        if ($this->menus->removeElement($menu)) {
            $menu->removeFrite($this);
        }

        return $this;
    }
}
