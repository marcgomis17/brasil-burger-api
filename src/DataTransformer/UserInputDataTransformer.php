<?php

namespace App\DataTransformer;

use App\Entity\User;
use ApiPlatform\Core\DataTransformer\DataTransformerInterface;

final class UserInputDataTransformer implements DataTransformerInterface {
    public function transform($data, string $to, array $context = []) {
        $user = new User();
        $data->prenom = $user->getPrenom();
        $data->nom = $user->getNom();
        $data->email = $user->getEmail();
        $data->plainPassword = $user->getPlainPassword();
        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsTransformation($data, string $to, array $context = []): bool {
        // in the case of an input, the value given here is an array (the JSON decoded).
        // if it's a User we transformed the data already
        if ($data instanceof User) {
            return false;
        }

        return User::class === $to && null !== ($context['input']['User'] ?? null);
    }
}
