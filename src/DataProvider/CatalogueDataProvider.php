<?php

namespace App\DataProvider;

use App\Entity\Catalogue;
use App\Repository\MenuRepository;
use App\Repository\BurgerRepository;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;

final class CatalogueDataProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface {
    private $burgerRepo;
    private $menuRepo;

    public function __construct(BurgerRepository $burgerRepository, MenuRepository $menuRepository) {
        $this->burgerRepo = $burgerRepository;
        $this->menuRepo = $menuRepository;
    }

    public function supports(string $resourceClass, ?string $operationName = null, array $context = []): bool {
        return $resourceClass === Catalogue::class;
    }

    public function getItem(string $resourceClass, $id, ?string $operationName = null, array $context = []): ?Catalogue {
        $catalogue = new Catalogue();
        $burgers = $this->burgerRepo->findBy(['isAvailable' => true]);
        $menus = $this->menuRepo->findBy(['isAvailable' => true]);
        $catalogue->setBurgers($burgers);
        $catalogue->setMenus($menus);
        return $catalogue;
    }
}
