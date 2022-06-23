<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Client;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ClientPersister implements DataPersisterInterface {
    private $manager;
    private $hasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager) {
        $this->hasher = $passwordHasher;
        $this->manager = $entityManager;
    }

    public function supports($data): bool {
        return $data instanceof Client;
    }

    public function persist($data) {
        $data->setPassword($this->hasher->hashPassword($data, $data->getPassword()));
        $this->manager->persist($data);
        $this->manager->flush();
    }

    public function remove($data) {
    }
}
