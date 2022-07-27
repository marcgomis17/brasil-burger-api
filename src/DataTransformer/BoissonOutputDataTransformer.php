<?php

namespace App\DataTransformer;

use App\Entity\Boisson;
use App\DTO\BoissonOutput;
use ApiPlatform\Core\DataTransformer\DataTransformerInterface;

final class BoissonOutputDataTransformer implements DataTransformerInterface {
    public function supportsTransformation($data, string $to, array $context = []): bool {
        return Boisson::class === $to && $data instanceof Boisson;
    }

    public function transform($object, string $to, array $context = []) {
        $output = new BoissonOutput();
        $output->id = $object->getId();
        $output->nom = $object->getNom();
        $output->image = $object->getImage();
        return $output;
    }
}
