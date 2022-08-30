<?php

namespace App\DataTransformer;

use App\Entity\PortionFrite;
use ApiPlatform\Core\DataTransformer\DataTransformerInterface;

final class PortionFriteMenuInputDataTransformer implements DataTransformerInterface {
    public function supportsTransformation($data, string $to, array $context = []): bool {
        if ($data instanceof PortionFrite) {
            return false;
        }
        return PortionFrite::class && null !== ($context['input']['PortionFrite'] ?? null);
    }

    public function transform($object, string $to, array $context = []) {
        $portionFrite = new PortionFrite();
        $object->id = $portionFrite->getId();
        return $portionFrite;
    }
}
