<?php

namespace App\DataTransformer;

use App\Entity\TailleBoisson;
use App\DTO\TailleBoissonOutput;
use ApiPlatform\Core\DataTransformer\DataTransformerInterface;

final class TailleBoissonOutputDataTransformer implements DataTransformerInterface {
    public function supportsTransformation($data, string $to, array $context = []): bool {
        return TailleBoisson::class === $to && $data instanceof TailleBoisson;
    }

    public function transform($object, string $to, array $context = []) {
        $output = new TailleBoissonOutput();
        $output->id = $object->getId();
        $output->libelle = $object->getLibelle();
        $output->prix = $object->getPrix();
        return $output;
    }
}
