<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BoissonRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BoissonRepository::class)]
#[ApiResource(
    collectionOperations: [
        'get' => [
            'normalization_context' => ['groups' => ['product:read']],
        ],
        'post' => [
            'input_formats' => [
                'multipart' => ['multipart/form-data'],
            ],
            'denormalization_context' => ['groups' => ['product:write']],
            'normalization_context' => ['groups' => ['product:read:post']],
        ]
    ]
)]
class Boisson extends Produit {
    #[ORM\ManyToMany(targetEntity: Menu::class, mappedBy: 'boissons')]
    private $menus;

    #[ORM\ManyToMany(targetEntity: TailleBoisson::class, inversedBy: 'boissons')]
    #[Groups(['product:write', 'product:read', 'product:read:post', 'menu:read:post'])]
    private $tailles;

    #[ORM\ManyToOne(targetEntity: Complement::class, inversedBy: 'boissons')]
    private $complement;

    public function __construct() {
        parent::__construct();
        $this->menus = new ArrayCollection();
        $this->tailles = new ArrayCollection();
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
     * @return Collection<int, TailleBoisson>
     */
    public function getTailles(): Collection {
        return $this->tailles;
    }

    public function addTaille(TailleBoisson $taille): self {
        if (!$this->tailles->contains($taille)) {
            $this->tailles[] = $taille;
        }

        return $this;
    }

    public function removeTaille(TailleBoisson $taille): self {
        $this->tailles->removeElement($taille);

        return $this;
    }

    public function getComplement(): ?Complement {
        return $this->complement;
    }

    public function setComplement(?Complement $complement): self {
        $this->complement = $complement;

        return $this;
    }
}
