<?php

namespace App\DataTransformer;

use App\Entity\MenuBurger;
use App\DTO\MenuBurgerOutput;
use ApiPlatform\Core\DataTransformer\DataTransformerInterface;

final class MenuBurgerOutputDataTransformer implements DataTransformerInterface {
    public function supportsTransformation($data, string $to, array $context = []): bool {
        if ($data instanceof MenuBurger) {
            return false;
        }
        return MenuBurger::class === $to && $data instanceof MenuBurger;
    }

    public function transform($object, string $to, array $context = []) {
        $output = new MenuBurgerOutput();
        $output->id = $object->getId();
        $output->quantite = $object->getQuantite();
        $output->burger = $object->getBurger()->getId();
        return $output;
    }
}
