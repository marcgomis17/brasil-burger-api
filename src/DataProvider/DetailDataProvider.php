<?php

namespace App\DataProvider;

use App\Entity\Detail;
use App\Repository\ProduitRepository;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;

class DetailDataProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface {
    private $produitRepo;

    public function __construct(ProduitRepository $produitReposittory) {
        $this->produitRepo = $produitReposittory;
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
        $details->setProduit($produit);
        $details->setBoissons($boissons);
        $details->setFrites($frites);
        return $details;
    }
}
