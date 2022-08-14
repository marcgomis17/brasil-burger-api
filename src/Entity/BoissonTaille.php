<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BoissonRepository;

#[ORM\Entity(repositoryClass: BoissonRepository::class)]
class BoissonTaille {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Boisson::class, inversedBy: 'boissonTailles')]
    private $boisson;

    #[ORM\ManyToOne(targetEntity: TailleBoisson::class, inversedBy: 'boissonTailles')]
    #[ORM\JoinColumn(nullable: false)]
    private $taille;

    #[ORM\OneToMany(mappedBy: 'boissonTaille', targetEntity: BoissonTailleCommande::class)]
    private $boissonTailleCommandes;

    public function __construct()
    {
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
    public function getBoissonTailleCommandes(): Collection
    {
        return $this->boissonTailleCommandes;
    }

    public function addBoissonTailleCommande(BoissonTailleCommande $boissonTailleCommande): self
    {
        if (!$this->boissonTailleCommandes->contains($boissonTailleCommande)) {
            $this->boissonTailleCommandes[] = $boissonTailleCommande;
            $boissonTailleCommande->setBoissonTaille($this);
        }

        return $this;
    }

    public function removeBoissonTailleCommande(BoissonTailleCommande $boissonTailleCommande): self
    {
        if ($this->boissonTailleCommandes->removeElement($boissonTailleCommande)) {
            // set the owning side to null (unless already changed)
            if ($boissonTailleCommande->getBoissonTaille() === $this) {
                $boissonTailleCommande->setBoissonTaille(null);
            }
        }

        return $this;
    }
}
