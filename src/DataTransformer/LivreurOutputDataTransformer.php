<?php

namespace App\DataTransformer;

use App\Entity\Livreur;
use App\DTO\LivreurOutput;
use ApiPlatform\Core\DataTransformer\DataTransformerInterface;

final class LivreurOutputDataTransformer implements DataTransformerInterface {
    public function supportsTransformation($data, string $to, array $context = []): bool {
        return LivreurOutput::class === $to && $data instanceof Livreur;
    }

    public function transform($object, string $to, array $context = []) {
        $output = new LivreurOutput();
        $output->prenom = $object->getPrenom();
        $output->nom = $object->getNom();
        $output->email = $object->getEmail();
        $output->matriculeMoto = $object->getMatriculeMoto();
        return $output;
    }
}
