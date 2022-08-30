<?php

namespace App\DataTransformer;

use App\Entity\Burger;
use App\DTO\BurgerOutput;
use ApiPlatform\Core\DataTransformer\DataTransformerInterface;

final class BurgerOutputDataTransformer implements DataTransformerInterface {
    public function supportsTransformation($data, string $to, array $context = []): bool {
        return BurgerOutput::class === $to && $data instanceof Burger;
    }

    public function transform($object, string $to, array $context = []) {
        $output = new BurgerOutput();
        $output->id = $object->getId();
        $output->nom = $object->getNom();
        $output->prix = $object->getPrix();
        $output->image = $object->getImage();
        return $output;
    }
}
