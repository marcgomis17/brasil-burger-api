<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProduitRepository;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

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
#[ApiResource(collectionOperations: [
    "get",
    "post" => [
        "security" => "is_granted('ROLE_GESTIONNAIRE')"
    ]
], itemOperations: [
    'get',
    "put" => [
        "security" => "is_granted('ROLE_GESTIONNAIRE')"
    ]
])]
class Produit {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["product:read:users", "product:read:gestionnaire"])]
    private $id;

    #[ORM\Column(type: 'string', length: 100, unique: true)]
    #[Groups(["product:read:users", "product:read:gestionnaire"])]
    #[Assert\NotBlank()]
    private $nom;

    #[ORM\Column(type: 'integer')]
    #[Groups(["product:read:users", "product:read:gestionnaire"])]
    #[Assert\NotBlank()]
    private $prix;

    #[ORM\Column(type: 'string', length: 30, nullable: true)]
    #[Groups("product:read:gestionnaire")]
    #[ApiProperty(security: "is_granted('ROLE_GESTIONNAIRE')")]
    private $etat;

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

    public function getEtat(): ?string {
        return $this->etat;
    }

    public function setEtat(?string $etat): self {
        $this->etat = $etat;

        return $this;
    }
}
