<?php

namespace App\DataTransformer;

use App\Entity\Gestionnaire;
use ApiPlatform\Core\DataTransformer\DataTransformerInterface;

final class GestionnaireInputDataTransformer implements DataTransformerInterface {
    public function transform($object, string $to, array $context = []) {
        $gestionnaire = new Gestionnaire();
        $object->prenom = $gestionnaire->getPrenom();
        $object->nom = $gestionnaire->getNom();
        $object->email = $gestionnaire->getEmail();
        $object->plainPassword = $gestionnaire->getPlainPassword();
        return $gestionnaire;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool {
        if ($data instanceof Gestionnaire) {
            return false;
        }
        return Gestionnaire::class === $to && null !== ($context['input']['Gestionnaire'] ?? null);
    }
}
