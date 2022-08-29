<?php

namespace App\DataProvider;

use App\Entity\ProduitComplement;
use App\Repository\BurgerRepository;
use App\Repository\TailleBoissonRepository;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Repository\PortionFriteRepository;

class ProduitComplementProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface {
    private $burgerRepo;
    private $tailleRepo;
    private $fritesRepo;

    public function __construct(BurgerRepository $burgerRepository, TailleBoissonRepository $tailleRepository, PortionFriteRepository $fritesRepository) {
        $this->burgerRepo = $burgerRepository;
        $this->tailleRepo = $tailleRepository;
        $this->fritesRepo = $fritesRepository;
    }

    public function supports(string $resourceClass, ?string $operationName = null, array $context = []): bool {
        return $resourceClass === ProduitComplement::class;
    }

    public function getItem(string $resourceClass, $id, ?string $operationName = null, array $context = []) {
        $produitComplement = new ProduitComplement();
        $produitComplement->setBurgers($this->burgerRepo->findAll());
        $produitComplement->setTailles($this->tailleRepo->findAll());
        $produitComplement->setFrites($this->fritesRepo->findAll());
        return $produitComplement;
    }
}
