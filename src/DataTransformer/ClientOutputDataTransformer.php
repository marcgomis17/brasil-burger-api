<?php

namespace App\DataTransformer;

use App\Entity\Client;
use App\DTO\ClientOutput;
use ApiPlatform\Core\DataTransformer\DataTransformerInterface;

final class ClientOutputDataTransformer implements DataTransformerInterface {
    public function transform($object, string $to, array $context = []) {
        $output = new ClientOutput();
        $output->id = $object->getId();
        $output->prenom = $object->getPrenom();
        $output->nom = $object->getNom();
        $output->email = $object->getEmail();
        $output->telephone = $object->getTelephone();
        $output->adresse = $object->getAdresse();
        return $output;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool {
        return ClientOutput::class === $to && $data instanceof Client;
    }
}
