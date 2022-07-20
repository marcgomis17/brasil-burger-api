<?php

namespace App\DataTransformer;

use App\Entity\User;
use App\DTO\UserOutput;
use ApiPlatform\Core\DataTransformer\DataTransformerInterface;

final class UserOutputDataTransformer implements DataTransformerInterface {
    public function transform($object, string $to, array $context = []) {
        $output = new UserOutput();
        $output->id = $object->getId();
        $output->prenom = $object->getPrenom();
        $output->nom = $object->getNom();
        $output->email = $object->getEmail();
        return $output;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool {
        return UserOutput::class === $to && $data instanceof User;
    }
}
