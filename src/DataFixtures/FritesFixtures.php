<?php

namespace App\DataFixtures;

use App\Entity\PortionFrite;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class FritesFixtures extends Fixture {
    public function load(ObjectManager $manager): void {
        $frites_n = ['Big', 'Medium', 'Small'];
        $frites_q = ['GM', 'Med', 'Small'];
        $frites_p = [1000, 700, 500];
        for ($i = 0; $i < 3; $i++) {
            $frites = new PortionFrite();
            $frites->setNom($frites_n[$i]);
            $frites->setPortion($frites_q[$i])
                ->setPrix($frites_p[$i]);
            $manager->persist($frites);
        }
        $manager->flush();
    }
}
