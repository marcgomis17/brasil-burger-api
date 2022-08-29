<?php

namespace App\DataPersister;

use App\Entity\Livraison;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Doctrine\ORM\EntityManagerInterface;

class LivraisonPersister implements DataPersisterInterface {
    private $em;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->em = $entityManager;
    }

    public function supports($data): bool {
        return $data instanceof Livraison;
    }

    public function persist($data) {
        $data->getLivreur()->setEtat(false);
        foreach ($data->getCommandes() as $commande) {
            $commande->setEtat("En livraison");
        }
        $this->em->persist($data);
        $this->em->flush();
    }

    public function remove($data) {
    }
}
