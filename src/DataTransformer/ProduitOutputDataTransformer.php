<?php

namespace App\DataTransformer;

use App\Entity\Produit;
use App\DTO\ProduitOutput;
use ApiPlatform\Core\DataTransformer\DataTransformerInterface;

class ProduitOutputDataTransformer implements DataTransformerInterface {
    public function supportsTransformation($data, string $to, array $context = []): bool {
        return ProduitOutput::class === $to && $data instanceof Produit;
    }

    public function transform($object, string $to, array $context = []) {
        $output = new ProduitOutput();
        $output->id = $object->getId();
        $output->nom = $object->getNom();
        $output->prix = $object->getPrix();
        $output->image = $object->getImage();
        return $output;
    }
}
