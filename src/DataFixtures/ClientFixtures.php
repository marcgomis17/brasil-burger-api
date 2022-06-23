<?php

namespace App\DataFixtures;

use App\Entity\Client;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ClientFixtures extends Fixture {
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $hasher) {
        $this->passwordHasher = $hasher;
    }

    public function load(ObjectManager $manager): void {
        $client = new Client();
        $client->setEmail("client@gmail.com")
            ->setPassword($this->passwordHasher->hashPassword($client, "clientpass"));
        $manager->persist($client);
        $manager->flush();
    }
}
