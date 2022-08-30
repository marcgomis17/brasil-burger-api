<?php

namespace App\Entity;

use App\DTO\TailleBoissonInput;
use App\DTO\TailleBoissonOutput;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TailleBoissonRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ORM\Entity(repositoryClass: TailleBoissonRepository::class)]
#[ApiResource(
    /* input: TailleBoissonInput::class,
    output: TailleBoissonOutput::class, */
    collectionOperations: [
        'get' => [
            "normalization_context" => ["groups" => ['taille:read']],
        ],
        'post' => [
            "denormalization_context" => ["groups" => ['taille:write']],
            "normalization_context" => ["groups" => ['taille:read']],
            'security' => "is_granted('ROLE_GESTIONNAIRE')",
        ]
    ],
    itemOperations: [
        'get',
        'put' => [
            'security' => "is_granted('ROLE_GESTIONNAIRE')",
        ],
    ]
)]
class TailleBoisson {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['menu:write', 'menu:read', 'taille:read', 'product:read', 'product:write', 'order:write', 'details:read', 'menu:add:read'])]
    private $id;

    #[ORM\Column(type: 'string', length: 100, unique: true)]
    #[Groups(['taille:write', 'taille:read', 'details:read', 'menu:add:read'])]
    private $libelle;

    #[ORM\Column(type: 'integer')]
    #[Groups(['taille:write', 'taille:read', 'menu:read', 'details:read'])]
    private $prix;

    #[ORM\ManyToMany(targetEntity: Boisson::class, mappedBy: 'tailles')]
    #[Groups(['details:read'])]
    private $boissons;

    #[ORM\OneToMany(mappedBy: 'taille', targetEntity: BoissonTaille::class)]
    private $boissonTailles;

    public function __construct() {
        $this->boissons = new ArrayCollection();
        $this->boissonTailles = new ArrayCollection();
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

    /**
     * @return Collection<int, BoissonTaille>
     */
    public function getBoissonTailles(): Collection {
        return $this->boissonTailles;
    }

    public function addBoissonTaille(BoissonTaille $boissonTaille): self {
        if (!$this->boissonTailles->contains($boissonTaille)) {
            $this->boissonTailles[] = $boissonTaille;
            $boissonTaille->setTaille($this);
        }

        return $this;
    }

    public function removeBoissonTaille(BoissonTaille $boissonTaille): self {
        if ($this->boissonTailles->removeElement($boissonTaille)) {
            // set the owning side to null (unless already changed)
            if ($boissonTaille->getTaille() === $this) {
                $boissonTaille->setTaille(null);
            }
        }

        return $this;
    }
}
