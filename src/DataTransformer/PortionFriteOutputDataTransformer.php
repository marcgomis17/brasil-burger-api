<?php

namespace App\DataTransformer;

use App\Entity\PortionFrite;
use App\DTO\PortionFriteOutput;
use ApiPlatform\Core\DataTransformer\DataTransformerInterface;

final class PortionFriteOutputDataTransformer implements DataTransformerInterface {
    public function supportsTransformation($data, string $to, array $context = []): bool {
        return PortionFriteOutput::class === $to && $data instanceof PortionFrite;
    }

    public function transform($object, string $to, array $context = []) {
        $output = new PortionFriteOutput();
        $output->id = $object->getId();
        $output->nom = $object->getNom();
        $output->portion = $object->getPortion();
        $output->image = $object->getImage();
        return $output;
    }
}
