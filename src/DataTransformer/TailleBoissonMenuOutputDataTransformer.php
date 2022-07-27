<?php

namespace App\DataTransformer;

use App\Entity\TailleBoisson;
use App\DTO\TailleBoissonMenuOutput;
use ApiPlatform\Core\DataTransformer\DataTransformerInterface;

final class TailleBoissonMenuOutputDataTransformer implements DataTransformerInterface {
    public function supportsTransformation($data, string $to, array $context = []): bool {
        if ($data instanceof TailleBoisson) {
            return false;
        }
        return TailleBoisson::class === $to && null !== ($context['output']['TailleBoisson'] ?? null);
    }

    public function transform($object, string $to, array $context = []) {
        $output = new TailleBoissonMenuOutput();
        $output->id = $object->getId();
        return $output;
    }
}
