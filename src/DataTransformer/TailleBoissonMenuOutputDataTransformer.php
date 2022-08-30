<?php

namespace App\DataTransformer;

use App\Entity\TailleBoisson;
use App\DTO\TailleBoissonMenuIO;
use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\DTO\TailleBoissonOutput;

final class TailleBoissonMenuOutputDataTransformer implements DataTransformerInterface {
    public function supportsTransformation($data, string $to, array $context = []): bool {
        return TailleBoissonOutput::class === $to && null !== ($context['output']['TailleBoisson'] ?? null);
    }

    public function transform($object, string $to, array $context = []) {
        $output = new TailleBoissonMenuIO();
        $output->id = $object->getId();
        return $output;
    }
}
