<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BoissonTailleRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BoissonTailleRepository::class)]
#[ApiResource()]
class BoissonTaille {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['product:read', 'order:read', 'user:read'])]
    private $id;

    #[ORM\ManyToOne(targetEntity: Boisson::class, inversedBy: 'boissonTailles')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['order:write'])]
    private $boisson;

    #[ORM\ManyToOne(targetEntity: TailleBoisson::class, inversedBy: 'boissonTailles')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['order:write'])]
    private $taille;

    #[ORM\OneToMany(mappedBy: 'boissonTailles', targetEntity: BoissonTailleCommande::class)]
    private $boissonTailleCommandes;

    public function __construct() {
        $this->boissonTailleCommandes = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getBoisson(): ?Boisson {
        return $this->boisson;
    }

    public function setBoisson(?Boisson $boisson): self {
        $this->boisson = $boisson;

        return $this;
    }

    public function getTaille(): ?TailleBoisson {
        return $this->taille;
    }

    public function setTaille(?TailleBoisson $taille): self {
        $this->taille = $taille;

        return $this;
    }

    /**
     * @return Collection<int, BoissonTailleCommande>
     */
    public function getBoissonTailleCommandes(): Collection {
        return $this->boissonTailleCommandes;
    }

    public function addBoissonTailleCommande(BoissonTailleCommande $boissonTailleCommande): self {
        if (!$this->boissonTailleCommandes->contains($boissonTailleCommande)) {
            $this->boissonTailleCommandes[] = $boissonTailleCommande;
            $boissonTailleCommande->setBoissonTailles($this);
        }

        return $this;
    }

    public function removeBoissonTailleCommande(BoissonTailleCommande $boissonTailleCommande): self {
        if ($this->boissonTailleCommandes->removeElement($boissonTailleCommande)) {
            // set the owning side to null (unless already changed)
            if ($boissonTailleCommande->getBoissonTailles() === $this) {
                $boissonTailleCommande->setBoissonTailles(null);
            }
        }

        return $this;
    }
}
