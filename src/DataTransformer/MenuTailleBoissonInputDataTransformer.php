<?php

namespace App\DataTransformer;

use App\Entity\MenuTailleBoisson;
use ApiPlatform\Core\DataTransformer\DataTransformerInterface;

final class MenuTailleBoissonInputDataTransformer implements DataTransformerInterface {
    public function supportsTransformation($data, string $to, array $context = []): bool {
        if ($data instanceof MenuTailleBoisson) {
            return false;
        }
        return MenuTailleBoisson::class === $to && null !== ($context['input']['MenuTailleBoisson'] ?? null);
    }

    public function transform($object, string $to, array $context = []) {
        $menuTaille = new MenuTailleBoisson();
        $object->quantite = $menuTaille->getQuantite();
        return $menuTaille;
    }
}
