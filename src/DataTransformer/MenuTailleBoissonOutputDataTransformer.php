<?php

namespace App\DataTransformer;

use App\DTO\TailleBoissonMenuIO;
use App\Entity\MenuTailleBoisson;
use App\DTO\MenuTailleBoissonOutput;
use ApiPlatform\Core\DataTransformer\DataTransformerInterface;

final class MenuTailleBoissonOutputDataTransformer implements DataTransformerInterface {
    private TailleBoissonMenuIO $taille;

    public function supportsTransformation($data, string $to, array $context = []): bool {
        if ($data instanceof MenuTailleBoisson) {
            return false;
        }
        return MenuTailleBoissonOutput::class === $to && $data instanceof MenuTailleBoisson;
    }

    public function transform($object, string $to, array $context = []) {
        $output = new MenuTailleBoissonOutput($this->taille);
        $output->id = $object->getId();
        $output->quantite = $object->getQuantite();
        return $output;
    }
}
