<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
#[ApiResource(
    collectionOperations: [
        'get' => [
            'method' => 'GET',
            'normalization_context' => ['groups' => ['menu:read']],
        ],
        'post' => [
            'input_formats' => [
                'multipart' => ['multipart/form-data'],
            ],
            'security' => "is_granted('ROLE_GESTIONNAIRE')",
            'denormalization_context' => ['groups' => ['menu:write']],
            'normalization_context' => ['groups' => ['menu:read:post']],
        ]
    ],
    itemOperations: [
        'get',
        'put' => [
            'security' => "is_granted('ROLE_GESTIONNAIRE')",
            'denormalization_context' => ['groups' => ['menu:write']],
        ],
        'patch' => [
            'security' => "is_granted('ROLE_GESTIONNAIRE')",
            'denormalization_context' => ['groups' => ['menu:write']],
        ]
    ]
)]
class Menu {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['menu:read', 'menu:read:post', 'orders:write'])]
    private $id;

    #[ORM\Column(type: 'string', length: 100, unique: true)]
    #[Groups(['menu:write', 'menu:read', 'menu:read:post'])]
    #[Assert\NotBlank()]
    private $nom;

    #[ORM\Column(type: 'integer')]
    #[Groups(['menu:read', 'menu:read:post'])]
    #[Assert\All(
        [
            new Assert\NotBlank(),
            new Assert\Positive()
        ]
    )]
    private $prix;

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'menus')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['menu:read', 'menu:write', 'menu:read:post'])]
    private $gestionnaire;

    #[ORM\Column(type: 'blob')]
    private $image;

    // #[Groups(['menu:write'])]
    #[SerializedName('image')]
    private ?File $file;

    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuBurger::class, cascade: ["persist"])]
    #[Groups(['menu:read', 'menu:write', 'menu:read:post'])]
    #[Assert\Count(min: 1)]
    private $menuBurgers;

    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuPortionFrite::class, cascade: ["persist"])]
    #[Groups(['menu:read', 'menu:write', 'menu:read:post'])]
    #[Assert\Count(min: 1)]
    private $menuFrites;

    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuTailleBoisson::class, cascade: ["persist"])]
    #[Groups(['menu:read', 'menu:write', 'menu:read:post'])]
    #[Assert\Count(min: 1)]
    private $menuTailles;

    #[ORM\ManyToMany(targetEntity: Commande::class, mappedBy: 'menus')]
    private $commandes;

    public function __construct() {
        $this->commandes = new ArrayCollection();
        $this->menuBurgers = new ArrayCollection();
        $this->menuFrites = new ArrayCollection();
        $this->menuTailles = new ArrayCollection();
    }

    /**
     * Get the value of id
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id) {
        $this->id = $id;

        return $this;
    }

    public function getNom(): ?string {
        return $this->nom;
    }

    public function setNom(string $nom): self {
        $this->nom = $nom;

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
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->addMenu($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self {
        if ($this->commandes->removeElement($commande)) {
            $commande->removeMenu($this);
        }

        return $this;
    }

    public function getGestionnaire(): ?Gestionnaire {
        return $this->gestionnaire;
    }

    public function setGestionnaire(?Gestionnaire $gestionnaire): self {
        $this->gestionnaire = $gestionnaire;

        return $this;
    }

    /**
     * Get the value of file
     */
    public function getFile() {
        return $this->file;
    }

    /**
     * Set the value of file
     *
     * @return  self
     */
    public function setFile($file) {
        $this->file = $file;

        return $this;
    }

    public function getImage() {
        return $this->image;
    }

    public function setImage($image): self {
        $this->image = $image;

        return $this;
    }

    /**
     * Get the value of menuBurgers
     */
    public function getMenuBurgers() {
        return $this->menuBurgers;
    }

    /**
     * Set the value of menuBurgers
     *
     * @return  self
     */
    public function setMenuBurgers($menuBurgers) {
        $this->menuBurgers = $menuBurgers;

        return $this;
    }

    /**
     * @return Collection<int, MenuPortionFrite>
     */
    public function getMenuFrites(): Collection {
        return $this->menuFrites;
    }

    public function addMenuFrite(MenuPortionFrite $menuFrite): self {
        if (!$this->menuFrites->contains($menuFrite)) {
            $this->menuFrites[] = $menuFrite;
            $menuFrite->setMenu($this);
        }

        return $this;
    }

    public function removeMenuFrite(MenuPortionFrite $menuFrite): self {
        if ($this->menuFrites->removeElement($menuFrite)) {
            // set the owning side to null (unless already changed)
            if ($menuFrite->getMenu() === $this) {
                $menuFrite->setMenu(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MenuTailleBoisson>
     */
    public function getMenuTailles(): Collection {
        return $this->menuTailles;
    }

    public function addMenuTaille(MenuTailleBoisson $menuTaille): self {
        if (!$this->menuTailles->contains($menuTaille)) {
            $this->menuTailles[] = $menuTaille;
            $menuTaille->setMenu($this);
        }

        return $this;
    }

    public function removeMenuTaille(MenuTailleBoisson $menuTaille): self {
        if ($this->menuTailles->removeElement($menuTaille)) {
            // set the owning side to null (unless already changed)
            if ($menuTaille->getMenu() === $this) {
                $menuTaille->setMenu(null);
            }
        }

        return $this;
    }
}
