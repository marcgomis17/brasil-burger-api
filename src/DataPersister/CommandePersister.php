<?php

namespace App\DataPersister;

use App\Entity\Commande;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CommandePersister implements DataPersisterInterface {
    private TokenStorageInterface $token;
    private EntityManagerInterface $em;

    public function __construct(TokenStorageInterface $tokenStorage, EntityManagerInterface $entityManager) {
        $this->token = $tokenStorage;
        $this->em = $entityManager;
    }

    public function supports($data): bool {
        return $data instanceof Commande;
    }

    public function persist($data) {
        $data->setClient($this->token->getToken()->getUser());
        $data->setZone($data->getQuartier()->getZone());
        $this->em->persist($data);
        $this->em->flush();
    }

    public function remove($data) {
    }
}
