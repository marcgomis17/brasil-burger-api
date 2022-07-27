<?php

namespace App\Entity;

use App\DTO\ProduitInput;
use App\DTO\ProduitOutput;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProduitRepository;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
#[InheritanceType("JOINED")]
#[DiscriminatorColumn(name: "discr", type: "string")]
#[DiscriminatorMap(
    [
        "burger" => "Burger",
        "menu" => "Menu",
        "boisson" => "Boisson",
        "portion_frite" => "PortionFrite"
    ]
)]
#[ApiResource(input: ProduitInput::class, output: ProduitOutput::class)]
class Produit {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected $id;

    #[ORM\Column(type: 'string', length: 100, unique: true)]
    #[Assert\NotBlank()]
    protected $nom;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Assert\All(
        [
            new Assert\NotBlank(),
            new Assert\Positive()
        ]
    )]
    protected $prix;

    #[ORM\Column(type: 'blob', nullable: true)]
    protected $image;

    #[ORM\Column(type: 'boolean', nullable: false)]
    protected $isAvailable;

    #[SerializedName('image')]
    // #[Groups(['menu:read', 'menu:write', 'menu:read:post'])]
    private ?File $file;

    #[SerializedName(('prix'))]
    private $sPrix;

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'produits')]
    #[ORM\JoinColumn(nullable: false)]
    private $gestionnaire;

    public function __construct() {
        $this->setIsAvailable(true);
        $this->commandes = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
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

    public function isIsAvailable(): ?bool {
        return $this->isAvailable;
    }

    public function setIsAvailable(?bool $isAvailable): self {
        $this->isAvailable = $isAvailable;

        return $this;
    }

    public function getImage() {
        return mb_convert_encoding(stream_get_contents($this->image), 'UTF-8'); // FIXME: stream_get_contents parameter[#1] must be a resource, string given
    }

    public function setImage($image): self {
        $this->image = $image;

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

    public function getGestionnaire(): ?Gestionnaire {
        return $this->gestionnaire;
    }

    public function setGestionnaire(?Gestionnaire $gestionnaire): self {
        $this->gestionnaire = $gestionnaire;

        return $this;
    }
}
