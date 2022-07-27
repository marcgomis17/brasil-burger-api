<?php

namespace App\DataTransformer;

use App\Entity\Gestionnaire;
use App\DTO\GestionnaireOutput;
use ApiPlatform\Core\DataTransformer\DataTransformerInterface;

final class GestionnaireOutputDataTransformer implements DataTransformerInterface {
    public function supportsTransformation($data, string $to, array $context = []): bool {
        return GestionnaireOutput::class === $to && $data instanceof Gestionnaire;
    }

    public function transform($object, string $to, array $context = []) {
        $output = new GestionnaireOutput();
        $output->id = $object->getId();
        $output->prenom = $object->getPrenom();
        $output->nom = $object->getNom();
        $output->email = $object->getEmail();
        return $output;
    }
}
