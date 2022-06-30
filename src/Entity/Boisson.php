<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BoissonRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BoissonRepository::class)]
#[ApiResource(
    collectionOperations: [
        'getAll' => [
            'method' => 'GET',
            'path' => '/gestionnaire/boissons',
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
            'normalization_context' => ['groups' => ['product:read']],
            'denormalization_context' => ['groups' => ['product:write']],
        ]
    ]
)]
class Boisson extends Produit {
    #[ORM\ManyToMany(targetEntity: Menu::class, mappedBy: 'boissons')]
    private $menus;

    #[ORM\ManyToMany(targetEntity: TailleBoisson::class, inversedBy: 'boissons', cascade: ['persist'])]
    #[ApiProperty()]
    #[Groups(['product:write', 'product:read'])]
    private $tailles;

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
}
