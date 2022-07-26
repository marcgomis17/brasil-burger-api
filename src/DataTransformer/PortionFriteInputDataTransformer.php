<?php

namespace App\DataTransformer;

use App\Entity\PortionFrite;
use ApiPlatform\Core\DataTransformer\DataTransformerInterface;

final class PortionFriteInputDataTransformer implements DataTransformerInterface {
    public function supportsTransformation($data, string $to, array $context = []): bool {
        if ($data instanceof PortionFrite) {
            return false;
        }
        return PortionFrite::class === $to && null !== ($context['input']['PortionFrite'] ?? null);
    }

    public function transform($object, string $to, array $context = []) {
        $frite = new PortionFrite();
        $object->nom = $frite->getNom();
        $object->portion = $frite->getportion();
        $object->prix = $frite->getSPrix();
        $object->image = $frite->getFile();
        return $frite;
    }
}
