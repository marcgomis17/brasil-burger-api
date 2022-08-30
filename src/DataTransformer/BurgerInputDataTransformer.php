<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Entity\Burger;

final class BurgerInputDataTransformer implements DataTransformerInterface {
    public function supportsTransformation($data, string $to, array $context = []): bool {
        if ($data instanceof Burger) {
            return false;
        }
        return Burger::class === $to && null !== ($context['input']['Burger'] ?? null);
    }

    public function transform($object, string $to, array $context = []) {
        $burger = new Burger();
        $object->nom = $burger->getNom();
        $object->prix = $burger->getSPrix();
        $object->image = $burger->getFile();
        return $burger;
    }
}
