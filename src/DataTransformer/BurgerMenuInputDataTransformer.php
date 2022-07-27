<?php

namespace App\DataTransformer;

use App\Entity\Burger;
use ApiPlatform\Core\DataTransformer\DataTransformerInterface;

final class BurgerMenuInputDataTransformer implements DataTransformerInterface {
    public function supportsTransformation($data, string $to, array $context = []): bool {
        if ($data instanceof Burger) {
            return false;
        }
        return Burger::class === $to && null !== ($context['input']['Burger'] ?? null);
    }

    public function transform($object, string $to, array $context = []) {
        $burger = new Burger();
        $object->id = $burger->getId();
        return $burger;
    }
}
