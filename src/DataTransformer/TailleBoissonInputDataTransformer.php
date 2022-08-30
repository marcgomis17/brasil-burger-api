<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Entity\TailleBoisson;

final class TailleBoissonInputDataTransformer implements DataTransformerInterface {
    public function supportsTransformation($data, string $to, array $context = []): bool {
        if ($data instanceof TailleBoisson) {
            return false;
        }
        return TailleBoisson::class === $to && null !== ($context['input']['TailleBoisson'] ?? null);
    }

    public function transform($object, string $to, array $context = []) {
        $taille = new TailleBoisson();
        $object->libelle = $taille->getLibelle();
        $object->prix = $taille->getPrix();
        return $taille;
    }
}
