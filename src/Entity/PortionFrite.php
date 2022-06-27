<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PortionFriteRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;

#[ORM\Entity(repositoryClass: PortionFriteRepository::class)]
#[ApiResource(
    collectionOperations: [
        "getAll" => [
            "method" => "get",
            "path" => "/gestionnaire/frites",
            "status" => Response::HTTP_OK,
            "normalization_context" => ["groups" => ["product:read:gestionnaire"]],
            "security" => "is_granted('ROLE_GESTIONNAIRE')"
        ],
        "getUsers" => [
            "method" => "get",
            "status" => Response::HTTP_OK,
            "normalization_context" => ["groups" => ["product:read:users"]]
        ],
        "post" => [
            "security" => "is_granted('ROLE_GESTIONNAIRE')"
        ]
    ],
    itemOperations: [
        'get',
        "put" => [
            "security" => "is_granted('ROLE_GESTIONNAIRE')"
        ]
    ]
)]
class PortionFrite extends Produit {
    #[ORM\Column(type: 'string', length: 70)]
    private $portion;

    #[ORM\ManyToMany(targetEntity: Menu::class, mappedBy: 'frites')]
    private $menus;

    #[ORM\OneToMany(mappedBy: 'frites', targetEntity: Complement::class)]
    private $complements;

    public function __construct() {
        $this->menus = new ArrayCollection();
        $this->complements = new ArrayCollection();
    }

    public function getPortion(): ?string {
        return $this->portion;
    }

    public function setPortion(string $portion): self {
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

    /**
     * @return Collection<int, Complement>
     */
    public function getComplements(): Collection {
        return $this->complements;
    }

    public function addComplement(Complement $complement): self {
        if (!$this->complements->contains($complement)) {
            $this->complements[] = $complement;
            $complement->setFrites($this);
        }

        return $this;
    }

    public function removeComplement(Complement $complement): self {
        if ($this->complements->removeElement($complement)) {
            // set the owning side to null (unless already changed)
            if ($complement->getFrites() === $this) {
                $complement->setFrites(null);
            }
        }

        return $this;
    }
}
