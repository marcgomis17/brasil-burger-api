<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Entity\MenuBurger;

final class MenuBurgerInputDataTransformer implements DataTransformerInterface {
    public function supportsTransformation($data, string $to, array $context = []): bool {
        if ($data instanceof MenuBurger) {
            return false;
        }
        return MenuBurger::class === $to && null !== ($context['input']['MenuBurger'] ?? null);
    }

    public function transform($object, string $to, array $context = []) {
        $menuBurger = new MenuBurger();
        $object->quantite = $menuBurger->getQuantite();
        $object->burger = $menuBurger->getBurger()->getId();
        return $menuBurger;
    }
}
