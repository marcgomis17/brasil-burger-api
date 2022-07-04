<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\LivreurRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: LivreurRepository::class)]
#[ApiResource(
    collectionOperations: [
        'get' => [
            'normalization_context' => ['groups' => ['users:read']],
        ],
        'post' => [
            'denormalization_context' => ['groups' => ['users:write']]
        ]
    ]
)]
class Livreur extends User {
    #[ORM\Column(type: 'string', length: 30)]
    #[Groups(['users:write', 'users:read'])]
    private $matriculeMoto;

    #[ORM\Column(type: 'boolean')]
    private $etat;

    #[ORM\OneToMany(mappedBy: 'livreur', targetEntity: Livraison::class)]
    private $livraisons;

    public function __construct() {
        $this->livraisons = new ArrayCollection();
    }

    public function getMatriculeMoto(): ?string {
        return $this->matriculeMoto;
    }

    public function setMatriculeMoto(string $matriculeMoto): self {
        $this->matriculeMoto = $matriculeMoto;

        return $this;
    }

    public function isEtat(): ?bool {
        return $this->etat;
    }

    public function setEtat(bool $etat): self {
        $this->etat = $etat;

        return $this;
    }

    /**
     * @return Collection<int, Livraison>
     */
    public function getLivraisons(): Collection {
        return $this->livraisons;
    }

    public function addLivraison(Livraison $livraison): self {
        if (!$this->livraisons->contains($livraison)) {
            $this->livraisons[] = $livraison;
            $livraison->setLivreur($this);
        }

        return $this;
    }

    public function removeLivraison(Livraison $livraison): self {
        if ($this->livraisons->removeElement($livraison)) {
            // set the owning side to null (unless already changed)
            if ($livraison->getLivreur() === $this) {
                $livraison->setLivreur(null);
            }
        }

        return $this;
    }
}