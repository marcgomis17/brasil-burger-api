<?php

namespace App\DataProvider;

use App\Entity\Detail;
use App\Repository\ProduitRepository;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Repository\TailleBoissonRepository;

class DetailDataProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface {
    private $produitRepo;
    private $tailleBoissonRepo;

    public function __construct(ProduitRepository $produitRepository, TailleBoissonRepository $tailleBoissonRepository) {
        $this->produitRepo = $produitRepository;
        $this->tailleBoissonRepo = $tailleBoissonRepository;
    }

    public function supports(string $resourceClass, ?string $operationName = null, array $context = []): bool {
        return $resourceClass === Detail::class;
    }

    public function getItem(string $resourceClass, $id, ?string $operationName = null, array $context = []): Detail {
        $details = new Detail();
        $details->setId($id);
        $produit = $this->produitRepo->findOneBy(['id' => $id]);
        $boissons = $this->produitRepo->findBy(['type' => 'boisson']);
        $frites = $this->produitRepo->findBy(['type' => 'frite']);
        $tailleBoissons = $this->tailleBoissonRepo->findAll();
        $details->setProduit($produit);
        $details->setBoissons($boissons);
        $details->setFrites($frites);
        $details->setTailleBoissons($tailleBoissons);
        return $details;
    }
}
