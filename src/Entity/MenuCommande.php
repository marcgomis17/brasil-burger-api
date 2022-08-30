<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuCommandeRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MenuCommandeRepository::class)]
#[ApiResource()]
class MenuCommande {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    #[Assert\Positive()]
    #[Groups(['order:write', 'order:read'])]
    private $quantite;

    #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: 'menuCommandes', cascade: ["persist"])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['order:write', 'order:read'])]
    private $menu;

    #[ORM\ManyToOne(targetEntity: Commande::class, inversedBy: 'menuCommandes')]
    private $commande;

    public function getId(): ?int {
        return $this->id;
    }

    public function getQuantite(): ?int {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self {
        $this->quantite = $quantite;

        return $this;
    }

    public function getMenu(): ?Menu {
        return $this->menu;
    }

    public function setMenu(?Menu $menu): self {
        $this->menu = $menu;

        return $this;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): self
    {
        $this->commande = $commande;

        return $this;
    }
}
