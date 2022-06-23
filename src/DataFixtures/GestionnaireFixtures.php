<?php

namespace App\DataFixtures;

use App\Entity\Gestionnaire;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class GestionnaireFixtures extends Fixture {
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $hasher) {
        $this->passwordHasher = $hasher;
    }

    public function load(ObjectManager $manager): void {
        $gestionnaire = new Gestionnaire();
        $gestionnaire->setEmail('admin@gmail.com')
            ->setPassword($this->passwordHasher->hashPassword($gestionnaire, "admin"));
        $manager->persist($gestionnaire);
        $manager->flush();
    }
}
