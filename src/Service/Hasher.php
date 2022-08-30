<?php

namespace App\Service;

use App\IService\IHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class Hasher implements IHasher {
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasherInterface) {
        $this->passwordHasher = $userPasswordHasherInterface;
    }

    public function hashPassword($object, string $password) {
        return $this->passwordHasher->hashPassword($object, $password);
    }
}
