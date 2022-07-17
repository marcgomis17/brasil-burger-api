<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TailleBoissonRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TailleBoissonRepository::class)]
#[ApiResource(
    collectionOperations: [
        "get",
        "post" => [
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "denormalization_context" => ['groups' => ['boisson:write']],
        ]
    ],
    itemOperations: [
        'get',
        "put" => [
            "security" => "is_granted('ROLE_GESTIONNAIRE')"
        ]
    ]
)]
class TailleBoisson {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['product:write', 'product:read', 'product:read:post', 'menu:write', 'menu:read:post', 'menu:taille:write', 'orders:write', 'orders:read', 'orders:read:post'])]
    private $id;

    #[ORM\Column(type: 'string', length: 100, unique: true)]
    #[Groups(['product:read', 'product:read:post', 'menu:read:post', 'boisson:write'])]
    private $libelle;

    #[ORM\Column(type: 'integer')]
    #[Groups(['product:read', 'product:read:post', 'menu:read:post', 'boisson:write'])]
    private $prix;

    #[ORM\ManyToMany(targetEntity: Boisson::class, mappedBy: 'tailles')]
    private $boissons;

    #[ORM\ManyToMany(targetEntity: Menu::class, mappedBy: 'tailles')]
    private $menus;

    #[ORM\OneToMany(mappedBy: 'tailles', targetEntity: MenuTailleBoisson::class)]
    private $menuTailleBoissons;

    #[ORM\OneToMany(mappedBy: 'taille', targetEntity: BoissonTailleBoisson::class)]
    private $boissonTailleBoissons;

    public function __construct() {
        $this->boissons = new ArrayCollection();
        $this->menus = new ArrayCollection();
        $this->menuTailleBoissons = new ArrayCollection();
        $this->boissonTailleBoissons = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getLibelle(): ?string {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection<int, Boisson>
     */
    public function getBoissons(): Collection {
        return $this->boissons;
    }

    public function addBoisson(Boisson $boisson): self {
        if (!$this->boissons->contains($boisson)) {
            $this->boissons[] = $boisson;
            $boisson->addTaille($this);
        }

        return $this;
    }

    public function removeBoisson(Boisson $boisson): self {
        if ($this->boissons->removeElement($boisson)) {
            $boisson->removeTaille($this);
        }

        return $this;
    }

    public function getPrix(): ?int {
        return $this->prix;
    }

    public function setPrix(int $prix): self {
        $this->prix = $prix;

        return $this;
    }

    /**
     * @return Collection<int, MenuTailleBoisson>
     */
    public function getMenuTailleBoissons(): Collection {
        return $this->menuTailleBoissons;
    }

    public function addMenuTailleBoisson(MenuTailleBoisson $menuTailleBoisson): self {
        if (!$this->menuTailleBoissons->contains($menuTailleBoisson)) {
            $this->menuTailleBoissons[] = $menuTailleBoisson;
            $menuTailleBoisson->setTailles($this);
        }

        return $this;
    }

    public function removeMenuTailleBoisson(MenuTailleBoisson $menuTailleBoisson): self {
        if ($this->menuTailleBoissons->removeElement($menuTailleBoisson)) {
            // set the owning side to null (unless already changed)
            if ($menuTailleBoisson->getTailles() === $this) {
                $menuTailleBoisson->setTailles(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BoissonTailleBoisson>
     */
    public function getBoissonTailleBoissons(): Collection {
        return $this->boissonTailleBoissons;
    }

    public function addBoissonTailleBoisson(BoissonTailleBoisson $boissonTailleBoisson): self {
        if (!$this->boissonTailleBoissons->contains($boissonTailleBoisson)) {
            $this->boissonTailleBoissons[] = $boissonTailleBoisson;
            $boissonTailleBoisson->setTaille($this);
        }

        return $this;
    }

    public function removeBoissonTailleBoisson(BoissonTailleBoisson $boissonTailleBoisson): self {
        if ($this->boissonTailleBoissons->removeElement($boissonTailleBoisson)) {
            // set the owning side to null (unless already changed)
            if ($boissonTailleBoisson->getTaille() === $this) {
                $boissonTailleBoisson->setTaille(null);
            }
        }

        return $this;
    }
}
