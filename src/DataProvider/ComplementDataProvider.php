<?php

namespace App\DataProvider;

use App\Entity\Complement;
use App\Repository\BoissonRepository;
use App\Repository\PortionFriteRepository;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use Doctrine\Common\Collections\ArrayCollection;
use PhpParser\Node\Expr\Cast\Array_;

final class ComplementDataProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface {
    private $boissonsRepo;
    private $fritesRepo;

    public function __construct(BoissonRepository $boissonRepository, PortionFriteRepository $portionFriteRepository) {
        $this->boissonsRepo = $boissonRepository;
        $this->fritesRepo = $portionFriteRepository;
    }

    public function supports(string $resourceClass, ?string $operationName = null, array $context = []): bool {
        return $resourceClass == Complement::class;
    }

    public function getCollection(string $resourceClass, ?string $operationName = null, array $context = []) {
        $complement = new Complement();
        $boissons = $this->boissonsRepo->findBy(['isAvailable' => true]);
        $frites = $this->fritesRepo->findBy(['isAvailable' => true]);
        foreach ($boissons as $boisson) {
            $complement->addBoisson($boisson);
        }
        foreach ($frites as $frite) {
            $complement->addFrite($frite);
        }
        return new ArrayCollection(array('boissons' => $complement->getBoissons(), 'frites' => $complement->getFrites()));
    }
}
