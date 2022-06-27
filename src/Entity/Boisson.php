<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BoissonRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BoissonRepository::class)]
#[ApiResource(
    collectionOperations: [
        "getAll" => [
            "method" => "get",
            "path" => "/gestionnaire/boissons",
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
class Boisson extends Produit {
    #[ORM\ManyToMany(targetEntity: Menu::class, mappedBy: 'boissons')]
    #[Groups(["product:read:users", "product:read:gestionnaire"])]
    private $menus;

    #[ORM\OneToMany(mappedBy: 'boisson', targetEntity: Complement::class)]
    private $complements;

    #[ORM\ManyToMany(targetEntity: TailleBoisson::class, mappedBy: 'boissons')]
    private $tailleBoissons;

    public function __construct() {
        $this->menus = new ArrayCollection();
        $this->complements = new ArrayCollection();
        $this->tailleBoissons = new ArrayCollection();
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
            $menu->addBoisson($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self {
        if ($this->menus->removeElement($menu)) {
            $menu->removeBoisson($this);
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
            $complement->setBoisson($this);
        }

        return $this;
    }

    public function removeComplement(Complement $complement): self {
        if ($this->complements->removeElement($complement)) {
            // set the owning side to null (unless already changed)
            if ($complement->getBoisson() === $this) {
                $complement->setBoisson(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TailleBoisson>
     */
    public function getTailleBoissons(): Collection {
        return $this->tailleBoissons;
    }

    public function addTailleBoisson(TailleBoisson $tailleBoisson): self {
        if (!$this->tailleBoissons->contains($tailleBoisson)) {
            $this->tailleBoissons[] = $tailleBoisson;
            $tailleBoisson->addBoisson($this);
        }

        return $this;
    }

    public function removeTailleBoisson(TailleBoisson $tailleBoisson): self {
        if ($this->tailleBoissons->removeElement($tailleBoisson)) {
            $tailleBoisson->removeBoisson($this);
        }

        return $this;
    }
}
