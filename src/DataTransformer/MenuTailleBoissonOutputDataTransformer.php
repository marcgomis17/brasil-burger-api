<?php

namespace App\DataTransformer;

use App\Entity\MenuTailleBoisson;
use App\DTO\MenuTailleBoissonOutput;
use App\DTO\TailleBoissonMenuOutput;
use ApiPlatform\Core\DataTransformer\DataTransformerInterface;

final class MenuTailleBoissonOutputDataTransformer implements DataTransformerInterface {
    private TailleBoissonMenuOutput $taille;
    public function supportsTransformation($data, string $to, array $context = []): bool {
        if ($data instanceof MenuTailleBoisson) {
            return false;
        }
        return MenuTailleBoisson::class === $to && $data instanceof MenuTailleBoisson;
    }

    public function transform($object, string $to, array $context = []) {
        $output = new MenuTailleBoissonOutput($this->taille);
        $output->id = $object->getId();
        $output->quantite = $object->getQuantite();
        return $output;
    }
}
