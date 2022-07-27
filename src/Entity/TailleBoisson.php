<?php

namespace App\Entity;

use App\DTO\TailleBoissonInput;
use App\DTO\TailleBoissonOutput;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TailleBoissonRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: TailleBoissonRepository::class)]
#[ApiResource(
    input: TailleBoissonInput::class,
    output: TailleBoissonOutput::class,
    collectionOperations: [
        "get",
        "post" => [
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
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
    private $id;

    #[ORM\Column(type: 'string', length: 100, unique: true)]
    private $libelle;

    #[ORM\Column(type: 'integer')]
    private $prix;

    /* #[ORM\ManyToMany(targetEntity: Boisson::class, mappedBy: 'tailles')]
    private $boissons;

    #[ORM\ManyToMany(targetEntity: Menu::class, mappedBy: 'tailles')]
    private $menus;

    #[ORM\OneToMany(mappedBy: 'tailles', targetEntity: MenuTailleBoisson::class)]
    private $menuTailleBoissons;

    #[ORM\OneToMany(mappedBy: 'taille', targetEntity: BoissonTaille::class)]
    private $boissonTaille;
 */
    public function __construct() {
        $this->boissons = new ArrayCollection();
        /* $this->menus = new ArrayCollection();
        $this->menuTailleBoissons = new ArrayCollection();
        $this->boissonTaille = new ArrayCollection(); */
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

    public function getPrix(): ?int {
        return $this->prix;
    }

    public function setPrix(int $prix): self {
        $this->prix = $prix;

        return $this;
    }
}
