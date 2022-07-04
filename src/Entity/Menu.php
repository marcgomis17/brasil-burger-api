<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

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
    private $nom;

    #[ORM\Column(type: 'integer')]
    #[Groups(['menu:write', 'menu:read:post', 'menu:read'])]
    private $prix;

    #[ORM\ManyToMany(targetEntity: Burger::class, inversedBy: 'menus')]
    #[Groups(['menu:read:post', 'menu:write'])]
    private $burgers;

    #[ORM\ManyToMany(targetEntity: Boisson::class, inversedBy: 'menus')]
    #[Groups(['menu:read:post', 'menu:write'])]
    private $boissons;

    #[ORM\ManyToMany(targetEntity: PortionFrite::class, inversedBy: 'menus')]
    #[Groups(['menu:read:post', 'menu:write'])]
    private $frites;

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'menus')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['menu:read', 'menu:read:post', 'menu:write'])]
    private $gestionnaire;

    #[SerializedName(('prix'))]
    #[Groups(['menu:write'])]
    private $sPrix;

    #[ORM\Column(type: 'blob')]
    private $image;

    #[Groups(['menu:write'])]
    #[SerializedName('image')]
    private ?File $file;

    #[ORM\ManyToMany(targetEntity: Commande::class, mappedBy: 'menus')]
    private $commandes;

    public function __construct() {
        $this->burgers = new ArrayCollection();
        $this->boissons = new ArrayCollection();
        $this->frites = new ArrayCollection();
        $this->commandes = new ArrayCollection();
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

    /**
     * @return Collection<int, Burger>
     */
    public function getBurgers(): Collection {
        return $this->burgers;
    }

    public function addBurger(Burger $burger): self {
        if (!$this->burgers->contains($burger)) {
            $this->burgers[] = $burger;
        }

        return $this;
    }

    public function removeBurger(Burger $burger): self {
        $this->burgers->removeElement($burger);

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
        }

        return $this;
    }

    public function removeBoisson(Boisson $boisson): self {
        $this->boissons->removeElement($boisson);

        return $this;
    }

    /**
     * @return Collection<int, PortionFrite>
     */
    public function getFrites(): Collection {
        return $this->frites;
    }

    public function addFrite(PortionFrite $frite): self {
        if (!$this->frites->contains($frite)) {
            $this->frites[] = $frite;
        }

        return $this;
    }

    public function removeFrite(PortionFrite $frite): self {
        $this->frites->removeElement($frite);

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

    /*  public function getCatalogue(): ?Catalogue
    {
        return $this->catalogue;
    }

    public function setCatalogue(?Catalogue $catalogue): self
    {
        $this->catalogue = $catalogue;

        return $this;
    } */

    public function getGestionnaire(): ?Gestionnaire {
        return $this->gestionnaire;
    }

    public function setGestionnaire(?Gestionnaire $gestionnaire): self {
        $this->gestionnaire = $gestionnaire;

        return $this;
    }

    public function getSPrix(): ?string {
        return $this->sPrix;
    }

    public function setSPrix(string $sPrix): self {
        $this->sPrix = $sPrix;

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
}
