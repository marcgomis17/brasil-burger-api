<?php

namespace App\Service;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class Hasher {
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasherInterface) {
        $this->passwordHasher = $userPasswordHasherInterface;
    }

    public function hashPassword($object, string $password) {
        return $this->passwordHasher->hashPassword($object, $password);
    }
}
