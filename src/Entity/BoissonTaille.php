<?php

namespace App\Entity;

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
}
