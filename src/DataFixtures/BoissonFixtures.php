<?php

namespace App\DataFixtures;

use App\Entity\Boisson;
use App\Entity\TailleBoisson;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BoissonFixtures extends Fixture {
    public function load(ObjectManager $manager): void {
        $boissons = ['Coca-cola', 'Sprite', 'Fanta Orange', 'Fanta Ananas', 'Schwepps Agrume'];
        $tailles = ['PM', 'GM'];
        for ($i = 0; $i < 5; $i++) {
            $taille = new TailleBoisson();
            $boisson = new Boisson();
            $taille->setLibelle($tailles[rand(0, 1)]);
            $boisson->addTailleBoisson($taille);
            $boisson->setNom($boissons[$i]);
            if ($taille->getLibelle() == "PM") {
                $boisson->setPrix(400);
                $taille->setPrix(400);
            } else {
                $boisson->setPrix(1000);
                $taille->setPrix(1000);
            }
            $manager->persist($taille);
            $manager->persist($boisson);
        }

        $manager->flush();
    }
}
