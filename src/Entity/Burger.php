<?php

namespace App\Entity;

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
class Burger extends Produit {
}
