<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommandeRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
#[ApiResource(
    collectionOperations: [
        'get' => [
            'method' => 'GET',
            'normalization_context' => ['groups' => ['order:read']],
        ],
        'post' => [
            'method' => 'POST',
            'security' => "is_granted('ROLE_GESTIONNAIRE') or is_granted('ROLE_CLIENT')",
            'denormalization_context' => ['groups' => ['order:write']],
            'normalization_context' => ['groups' => ['order:read']],
        ]
    ],
    itemOperations: [
        'get',
    ]
)]
#[ApiFilter(DateFilter::class, properties: ['commande.dateCommande'])]
class Commande {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['order:read', 'user:read', 'deliver:read', 'deliver:write'])]
    private $id;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'commandes')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['order:read'])]
    private $client;

    #[ORM\ManyToOne(targetEntity: Quartier::class, inversedBy: 'commandes')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['order:write', 'order:read', 'user:read'])]
    private $quartier;

    #[ORM\ManyToOne(targetEntity: Zone::class, inversedBy: 'commandes')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['order:read', 'user:read'])]
    private $zone;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(['order:read', 'user:read'])]
    private $prixCommande;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(['order:read', 'user:read'])]
    private $prixTotal;

    #[ORM\Column(type: 'datetime')]
    #[Groups(['order:read', 'user:read'])]
    private $dateCommande;

    #[ORM\Column(type: 'string', length: 30)]
    #[Groups(['order:read', 'user:read'])]
    private $numeroCommande;

    #[ORM\Column(type: 'string', length: 30)]
    #[Groups(['order:read', 'user:read'])]
    private $etat;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: BurgerCommande::class, cascade: ["persist"])]
    #[SerializedName('burgers')]
    #[Groups(['order:write', 'order:read', 'user:read'])]
    private $burgerCommandes;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: MenuCommande::class, cascade: ["persist"])]
    #[SerializedName('menus')]
    #[Groups(['order:write', 'order:read', 'user:read'])]
    private $menuCommandes;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: PortionFriteCommande::class, cascade: ["persist"])]
    #[SerializedName('frites')]
    #[Groups(['order:write', 'order:read', 'user:read'])]
    private $portionFriteCommande;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: BoissonTailleCommande::class, cascade: ["persist"])]
    #[SerializedName('boissons')]
    #[Groups(['order:write', 'order:read', 'user:read'])]
    private $boissonTailleCommandes;

    #[ORM\ManyToOne(targetEntity: Livraison::class, inversedBy: 'commandes')]
    private $livraison;

    public function __construct() {
        $this->burgerCommandes = new ArrayCollection();
        $this->menuCommandes = new ArrayCollection();
        $this->portionFriteCommande = new ArrayCollection();
        $this->boissonTailleCommandes = new ArrayCollection();
        $this->setDateCommande(new DateTime());
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getZone(): ?Zone {
        return $this->zone;
    }

    public function setZone(?Zone $zone): self {
        $this->zone = $zone;

        return $this;
    }

    public function getClient(): ?Client {
        return $this->client;
    }

    public function setClient(?Client $client): self {
        $this->client = $client;

        return $this;
    }


    public function getQuartier(): ?Quartier {
        return $this->quartier;
    }

    public function setQuartier(?Quartier $quartier): self {
        $this->quartier = $quartier;

        return $this;
    }

    /**
     * @return Collection<int, BurgerCommande>
     */
    public function getBurgerCommandes(): Collection {
        return $this->burgerCommandes;
    }

    public function addBurgerCommande(BurgerCommande $burgerCommande): self {
        if (!$this->burgerCommandes->contains($burgerCommande)) {
            $this->burgerCommandes[] = $burgerCommande;
            $burgerCommande->setCommande($this);
        }

        return $this;
    }

    public function removeBurgerCommande(BurgerCommande $burgerCommande): self {
        if ($this->burgerCommandes->removeElement($burgerCommande)) {
            // set the owning side to null (unless already changed)
            if ($burgerCommande->getCommande() === $this) {
                $burgerCommande->setCommande(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MenuCommande>
     */
    public function getMenuCommandes(): Collection {
        return $this->menuCommandes;
    }

    public function addMenuCommande(MenuCommande $menuCommande): self {
        if (!$this->menuCommandes->contains($menuCommande)) {
            $this->menuCommandes[] = $menuCommande;
            $menuCommande->setCommande($this);
        }

        return $this;
    }

    public function removeMenuCommande(MenuCommande $menuCommande): self {
        if ($this->menuCommandes->removeElement($menuCommande)) {
            // set the owning side to null (unless already changed)
            if ($menuCommande->getCommande() === $this) {
                $menuCommande->setCommande(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PortionFriteCommande>
     */
    public function getPortionFriteCommande(): Collection {
        return $this->portionFriteCommande;
    }

    public function addPortionFriteCommande(PortionFriteCommande $portionFriteCommande): self {
        if (!$this->portionFriteCommande->contains($portionFriteCommande)) {
            $this->portionFriteCommande[] = $portionFriteCommande;
            $portionFriteCommande->setCommande($this);
        }

        return $this;
    }

    public function removePortionFriteCommande(PortionFriteCommande $portionFriteCommande): self {
        if ($this->portionFriteCommande->removeElement($portionFriteCommande)) {
            // set the owning side to null (unless already changed)
            if ($portionFriteCommande->getCommande() === $this) {
                $portionFriteCommande->setCommande(null);
            }
        }

        return $this;
    }


    public function getPrixCommande(): ?int {
        return $this->prixCommande;
    }

    public function setPrixCommande(?int $prixCommande): self {
        $this->prixCommande = $prixCommande;

        return $this;
    }

    public function getPrixTotal(): ?int {
        return $this->prixTotal;
    }

    public function setPrixTotal(?int $prixTotal): self {
        $this->prixTotal = $prixTotal;

        return $this;
    }

    public function getDateCommande(): ?\DateTimeInterface {
        return $this->dateCommande;
    }

    public function setDateCommande(\DateTimeInterface $dateCommande): self {
        $this->dateCommande = $dateCommande;

        return $this;
    }

    public function getNumeroCommande(): ?string {
        return $this->numeroCommande;
    }

    public function setNumeroCommande(string $numeroCommande): self {
        $this->numeroCommande = $numeroCommande;

        return $this;
    }

    public function getEtat(): ?string {
        return $this->etat;
    }

    public function setEtat(string $etat): self {
        $this->etat = $etat;

        return $this;
    }

    public function getLivraison(): ?Livraison {
        return $this->livraison;
    }

    public function setLivraison(?Livraison $livraison): self {
        $this->livraison = $livraison;

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
            $boissonTailleCommande->setCommande($this);
        }

        return $this;
    }

    public function removeBoissonTailleCommande(BoissonTailleCommande $boissonTailleCommande): self {
        if ($this->boissonTailleCommandes->removeElement($boissonTailleCommande)) {
            // set the owning side to null (unless already changed)
            if ($boissonTailleCommande->getCommande() === $this) {
                $boissonTailleCommande->setCommande(null);
            }
        }

        return $this;
    }
}
