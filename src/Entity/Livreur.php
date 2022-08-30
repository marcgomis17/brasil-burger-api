<?php

namespace App\Entity;

use App\DTO\LivreurInput;
use App\DTO\LivreurOutput;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\LivreurRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: LivreurRepository::class)]
#[ApiResource(
    /* input: LivreurInput::class,
    output: LivreurOutput::class, */
    collectionOperations: [
        'get' => [
            "normalization_context" => ["groups" => ['user:read']]
        ],
        'post' => [
            "denormalization_context" => ["groups" => ['user:write']],
            "normalization_context" => ["groups" => ['user:read']]
        ]
    ],
    itemOperations: [
        'get' => [
            "normalization_context" => ["groups" => ['user:read']]
        ],
        'put' => [
            "denormalization_context" => ["groups" => ['user:write']],
            "normalization_context" => ["groups" => ['user:read']]
        ],
        'patch' => [
            "denormalization_context" => ["groups" => ['user:write']],
            "normalization_context" => ["groups" => ['user:read']]
        ]
    ],
    subresourceOperations: [
        'get' => [
            "normalization_context" => ["groups" => ['user:read']]
        ]
    ]
)]
class Livreur extends User {
    #[ORM\Column(type: 'string', length: 30)]
    #[Groups(['user:write', 'user:read'])]
    private $matriculeMoto;

    #[ORM\Column(type: 'boolean')]
    #[Groups(['user:read'])]
    private $etat;

    #[ORM\OneToMany(mappedBy: 'livreur', targetEntity: Livraison::class)]
    #[ApiSubresource()]
    private $livraisons;

    public function __construct() {
        $this->livraisons = new ArrayCollection();
        $this->setEtat(true);
        $this->setIsVerified(true);
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
