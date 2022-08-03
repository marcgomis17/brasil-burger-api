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
    #[ORM\ManyToOne(targetEntity: TailleBoisson::class, inversedBy: 'boissons')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['product:write', 'product:read'])]
    private $taille;

    #[ORM\OneToMany(mappedBy: 'boisson', targetEntity: BoissonTaille::class)]
    private $boissonTaille;

    public function __construct() {
        $this->boissonTaille = new ArrayCollection();
        $this->setType('boisson');
    }

    /**
     * @return Collection<int, BoissonTaille>
     */
    public function getBoissonTailleBoissons(): Collection {
        return $this->boissonTaille;
    }

    public function addBoissonTailleBoisson(BoissonTaille $BoissonTaille): self {
        if (!$this->boissonTaille->contains($BoissonTaille)) {
            $this->boissonTaille[] = $BoissonTaille;
            $BoissonTaille->setBoisson($this);
        }

        return $this;
    }

    public function removeBoissonTailleBoisson(BoissonTaille $BoissonTaille): self {
        if ($this->boissonTaille->removeElement($BoissonTaille)) {
            // set the owning side to null (unless already changed)
            if ($BoissonTaille->getBoisson() === $this) {
                $BoissonTaille->setBoisson(null);
            }
        }

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
