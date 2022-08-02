<?php

namespace App\DataProvider;

use App\Entity\Complement;
use App\Repository\BoissonRepository;
use App\Repository\PortionFriteRepository;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use Doctrine\Common\Collections\ArrayCollection;
use PhpParser\Node\Expr\Cast\Array_;

final class ComplementDataProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface {
    private $boissonsRepo;
    private $fritesRepo;

    public function __construct(BoissonRepository $boissonRepository, PortionFriteRepository $portionFriteRepository) {
        $this->boissonsRepo = $boissonRepository;
        $this->fritesRepo = $portionFriteRepository;
    }

    public function supports(string $resourceClass, ?string $operationName = null, array $context = []): bool {
        return $resourceClass == Complement::class;
    }

    public function getItem(string $resourceClass, $id, ?string $operationName = null, array $context = []): Complement {
        $complement = new Complement();
        $frites = $this->fritesRepo->findBy(['isAvailable' => true]);
        $boissons = $this->boissonsRepo->findBy(['isAvailable' => true]);
        $complement->setFrites($frites);
        $complement->setBoissons($boissons);
        return $complement;
    }
}
