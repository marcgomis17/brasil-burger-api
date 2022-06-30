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
    #[Groups(['write', 'read', 'product:read'])]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $prix;

    #[ORM\Column(type: 'string', length: 100)]
    #[Groups(['read', 'menu:read', 'product:read'])]
    private $libelle;

    #[ORM\ManyToMany(targetEntity: Boisson::class, mappedBy: 'tailles')]
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
}
