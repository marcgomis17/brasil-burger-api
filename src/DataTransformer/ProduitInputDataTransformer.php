<?php

namespace App\DataTransformer;

use App\Entity\Produit;
use ApiPlatform\Core\DataTransformer\DataTransformerInterface;

final class ProduitInputDataTransformer implements DataTransformerInterface {
    public function supportsTransformation($data, string $to, array $context = []): bool {
        if ($data instanceof Produit) {
            return false;
        }
        return Produit::class === $to && null !== ($context['input']['Produit'] ?? null);
    }

    public function transform($object, string $to, array $context = []) {
        $produit = new Produit();
        $object->nom = $produit->getNom();
        $object->prix = $produit->getSPrix();
        $object->image = $produit->getFile();
        return $produit;
    }
}
