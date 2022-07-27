<?php

namespace App\DataTransformer;

use App\Entity\MenuPortionFrite;
use ApiPlatform\Core\DataTransformer\DataTransformerInterface;

final class MenuPortionFriteInputDataTransformer implements DataTransformerInterface {
    public function supportsTransformation($data, string $to, array $context = []): bool {
        if ($data instanceof MenuPortionFrite) {
            return false;
        }
        return MenuPortionFrite::class === $to && null !== ($context['input']['MenuPortionFrite'] ?? null);
    }

    public function transform($object, string $to, array $context = []) {
        $menuPortionFrite = new MenuPortionFrite();
        $object->quantite = $menuPortionFrite->getQuantite();
        return $menuPortionFrite;
    }
}
