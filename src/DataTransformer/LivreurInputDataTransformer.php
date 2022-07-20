<?php

namespace App\DataTransformer;

use App\Entity\Livreur;
use ApiPlatform\Core\DataTransformer\DataTransformerInterface;

final class LivreurInputDataTransformer implements DataTransformerInterface {
    public function transform($object, string $to, array $context = []) {
        $livreur = new Livreur();
        $object->prenom = $livreur->getPrenom();
        $object->nom = $livreur->getNom();
        $object->email = $livreur->getEmail();
        $object->plainPassword = $livreur->getPlainPassword();
        $object->matriculeMoto = $livreur->getMatriculeMoto();
        return $livreur;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool {
        if ($data instanceof Livreur) {
            return false;
        }
        return Livreur::class === $to && null !== ($context['input']['Livreur'] ?? null);
    }
}
