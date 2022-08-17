<?php

namespace App\Entity;

use App\DTO\BoissonInput;
use App\DTO\BoissonOutput;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BoissonRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BoissonRepository::class)]
#[ApiResource(
    /* input: BoissonInput::class,
    output: BoissonOutput::class, */
    collectionOperations: [
        'get' => [
            "normalization_context" => ["groups" => ['product:read']],
        ],
        'post' => [
            "denormalization_context" => ["groups" => ['product:write']],
            "normalization_context" => ["groups" => ['product:read']],
            'input_formats' => [
                'multipart' => ['multipart/form-data'],
            ],
            'security' => "is_granted('ROLE_GESTIONNAIRE')",
        ]
    ],
    itemOperations: [
        'get',
        'put' => [
            'input_formats' => [
                'multipart' => ['multipart/form-data'],
            ],
            'security' => "is_granted('ROLE_GESTIONNAIRE')",
        ],
    ]
)]
class Boisson extends Produit {
    #[ORM\ManyToMany(targetEntity: TailleBoisson::class, inversedBy: 'boissons')]
    #[Groups(['product:write', 'product:read'])]
    private $tailles;

    #[ORM\OneToMany(mappedBy: 'boisson', targetEntity: BoissonTaille::class)]
    #[Groups(['product:read'])]
    private $boissonTailles;

    public function __construct() {
        $this->tailles = new ArrayCollection();
        $this->boissonTailles = new ArrayCollection();
        $this->setType('boisson');
    }

    /**
     * @return Collection<int, TailleBoisson>
     */
    public function getTailles(): Collection {
        return $this->tailles;
    }

    public function addTaille(TailleBoisson $taille): self {
        if (!$this->tailles->contains($taille)) {
            $this->tailles[] = $taille;
        }

        return $this;
    }

    public function removeTaille(TailleBoisson $taille): self {
        $this->tailles->removeElement($taille);

        return $this;
    }

    /**
     * @return Collection<int, BoissonTaille>
     */
    public function getBoissonTailles(): Collection
    {
        return $this->boissonTailles;
    }

    public function addBoissonTaille(BoissonTaille $boissonTaille): self
    {
        if (!$this->boissonTailles->contains($boissonTaille)) {
            $this->boissonTailles[] = $boissonTaille;
            $boissonTaille->setBoisson($this);
        }

        return $this;
    }

    public function removeBoissonTaille(BoissonTaille $boissonTaille): self
    {
        if ($this->boissonTailles->removeElement($boissonTaille)) {
            // set the owning side to null (unless already changed)
            if ($boissonTaille->getBoisson() === $this) {
                $boissonTaille->setBoisson(null);
            }
        }

        return $this;
    }
}
