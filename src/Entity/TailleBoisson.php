<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TailleBoissonRepository;
use ApiPlatform\Core\Annotation\ApiResource;

#[ORM\Entity(repositoryClass: TailleBoissonRepository::class)]
#[ApiResource(
    collectionOperations: [
        "get",
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
class TailleBoisson {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $prix;

    #[ORM\Column(type: 'string', length: 100)]
    private $libelle;

    #[ORM\ManyToMany(targetEntity: Boisson::class, inversedBy: 'tailleBoissons')]
    private $boissons;

    public function __construct() {
        $this->boissons = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getPrix(): ?int {
        return $this->prix;
    }

    public function setPrix(int $prix): self {
        $this->prix = $prix;

        return $this;
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
        }

        return $this;
    }

    public function removeBoisson(Boisson $boisson): self {
        $this->boissons->removeElement($boisson);

        return $this;
    }
}
