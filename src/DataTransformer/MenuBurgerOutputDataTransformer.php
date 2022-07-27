<?php

namespace App\DataTransformer;

use App\Entity\MenuBurger;
use App\DTO\MenuBurgerOutput;
use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\DTO\BurgerMenuIO;

final class MenuBurgerOutputDataTransformer implements DataTransformerInterface {
    private BurgerMenuIO $burgerMenuOutput;

    public function supportsTransformation($data, string $to, array $context = []): bool {
        if ($data instanceof MenuBurger) {
            return false;
        }
        return MenuBurgerOutput::class === $to && $data instanceof MenuBurger;
    }

    public function transform($object, string $to, array $context = []) {
        $output = new MenuBurgerOutput($this->burgerMenuOutput);
        $output->id = $object->getId();
        $output->quantite = $object->getQuantite();
        return $output;
    }
}
