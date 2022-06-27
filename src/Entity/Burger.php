<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BurgerRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;

#[ORM\Entity(repositoryClass: BurgerRepository::class)]
#[ApiResource(collectionOperations: [
    "getAll" => [
        "method" => "get",
        "path" => "/gestionnaire/burgers",
        "status" => Response::HTTP_OK,
        "normalization_context" => ["groups" => ["product:read:gestionnaire"]],
        "security" => "is_granted('ROLE_GESTIONNAIRE')"
    ],
    "getUsers" => [
        "method" => "get",
        "status" => Response::HTTP_OK,
        "normalization_context" => ["groups" => ["product:read:users"]]
    ],
    "post" => [
        "security" => "is_granted('ROLE_GESTIONNAIRE')"
    ]
], itemOperations: [
    'get',
    "put" => [
        "security" => "is_granted('ROLE_GESTIONNAIRE')"
    ]
])]
class Burger extends Produit
{
    #[ORM\ManyToMany(targetEntity: Menu::class, mappedBy: 'burgers')]
    private $menus;

    public function __construct()
    {
        $this->menus = new ArrayCollection();
    }

    /**
     * @return Collection<int, Menu>
     */
    public function getMenus(): Collection
    {
        return $this->menus;
    }

    public function addMenu(Menu $menu): self
    {
        if (!$this->menus->contains($menu)) {
            $this->menus[] = $menu;
            $menu->addBurger($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        if ($this->menus->removeElement($menu)) {
            $menu->removeBurger($this);
        }

        return $this;
    }
}
