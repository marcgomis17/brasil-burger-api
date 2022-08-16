<?php

namespace App\Entity;

use App\DTO\ClientInput;
use App\DTO\ClientOutput;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ClientRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
#[ApiResource(
    /* input: ClientInput::class,
    output: ClientOutput::class, */
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
        ],
    ]
)]
class Client extends User {
    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    #[Groups(['user:read', 'user:write', 'order:read'])]
    private $adresse;

    #[ORM\Column(type: 'string', length: 30, nullable: true)]
    #[Groups(['user:read', 'user:write', 'order:read'])]
    private $telephone;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Commande::class)]
    #[ApiSubresource()]
    private $commandes;

    public function __construct() {
        $this->setRoles(['ROLE_CLIENT']);
        $this->setIsVerified(false);
        $this->commandes = new ArrayCollection();
    }

    public function getAdresse(): ?string {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTelephone(): ?string {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self {
        $this->telephone = $telephone;

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
            $commande->setClient($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getClient() === $this) {
                $commande->setClient(null);
            }
        }

        return $this;
    }
}
