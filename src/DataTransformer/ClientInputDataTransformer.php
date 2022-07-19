<?php

namespace App\DataTransformer;

use App\Entity\Client;
use ApiPlatform\Core\DataTransformer\DataTransformerInterface;

final class ClientInputDataTransformer implements DataTransformerInterface {
    public function transform($data, string $to, array $context = []) {
        $client = new Client();
        $data->prenom = $client->getPrenom();
        $data->nom = $client->getNom();
        $data->email = $client->getEmail();
        $data->plainPassword = $client->getPlainPassword();
        $data->adresse = $client->getAdresse();
        $data->telephone = $client->getTelephone();
        return $client;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool {
        // in the case of an input, the value given here is an array (the JSON decoded).
        // if it's a Client we transformed the data already
        if ($data instanceof Client) {
            return false;
        }

        return Client::class === $to && null !== ($context['input']['Client'] ?? null);
    }
}
