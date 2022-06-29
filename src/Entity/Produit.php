<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProduitRepository;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
#[InheritanceType("JOINED")]
#[DiscriminatorColumn(name: "discr", type: "string")]
#[DiscriminatorMap(
    [
        "burger" => "Burger",
        "boisson" => "Boisson",
        "portion_frite" => "PortionFrite"
    ]
)]
#[ApiResource()]
class Produit {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['product:read:gestionnaire', 'product:read:user'])]
    private $id;

    #[ORM\Column(type: 'string', length: 100, unique: true)]
    #[Assert\NotBlank()]
    #[Groups(['product:write', 'product:read:gestionnaire', 'product:read:user'])]
    private $nom;

    #[ORM\Column(type: 'integer')]
    #[Assert\NotBlank()]
    #[Groups(['product:write', 'product:read:gestionnaire', 'product:read:user'])]
    private $prix;

    #[Groups("product:read:gestionnaire")]
    #[ORM\Column(type: 'boolean', nullable: false)]
    private $isAvailable;

    #[ORM\ManyToMany(targetEntity: Commande::class, mappedBy: 'produits')]
    private $commandes;

    public function __construct() {
        $this->setIsAvailable(true);
        $this->commandes = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getNom(): ?string {
        return $this->nom;
    }

    public function setNom(string $nom): self {
        $this->nom = $nom;

        return $this;
    }

    public function getPrix(): ?int {
        return $this->prix;
    }

    public function setPrix(int $prix): self {
        $this->prix = $prix;

        return $this;
    }

    public function isIsAvailable(): ?bool {
        return $this->isAvailable;
    }

    public function setIsAvailable(?bool $isAvailable): self {
        $this->isAvailable = $isAvailable;

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->addProduit($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self {
        if ($this->commandes->removeElement($commande)) {
            $commande->removeProduit($this);
        }

        return $this;
    }
}
