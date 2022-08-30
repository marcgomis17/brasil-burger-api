<?php

namespace App\DataTransformer;

use App\Entity\Boisson;
use ApiPlatform\Core\DataTransformer\DataTransformerInterface;

final class BoissonInputDataTransformer implements DataTransformerInterface {
    public function supportsTransformation($data, string $to, array $context = []): bool {
        if ($data instanceof Boisson) {
            return false;
        }
        return Boisson::class === $to && null !== ($context['input']['Boisson'] ?? null);
    }

    public function transform($object, string $to, array $context = []) {
        $boisson = new Boisson();
        $object->nom = $boisson->getNom();
        $object->image = $boisson->getFile();
        return $boisson;
    }
}
