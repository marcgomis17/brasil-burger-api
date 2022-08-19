<?php

namespace App\DataPersister;

use App\Entity\Commande;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\IService\ICalculPrix;
use App\IService\IGenerator;
use App\Repository\BoissonTailleRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CommandePersister implements DataPersisterInterface {
    private TokenStorageInterface $token;
    private EntityManagerInterface $em;
    private ICalculPrix $calculator;
    private IGenerator $generator;

    public function __construct(TokenStorageInterface $tokenStorage, EntityManagerInterface $entityManager, ICalculPrix $calculPrixService, IGenerator $generatorService) {
        $this->token = $tokenStorage;
        $this->em = $entityManager;
        $this->calculator = $calculPrixService;
        $this->generator = $generatorService;
    }

    public function supports($data): bool {
        return $data instanceof Commande;
    }

    public function persist($data) {
        $prixCommande = $this->calculator->calculPrixCommande($data);
        $data->setClient($this->token->getToken()->getUser());
        $data->setZone($data->getQuartier()->getZone());
        $data->setPrixCommande($prixCommande);
        $data->setPrixTotal($prixCommande += $data->getZone()->getPrix());
        $data->setNumeroCommande($this->generator->generateOrderNumber());
        $data->setEtat('En cours');
        $this->em->persist($data);
        $this->em->flush();
    }

    public function remove($data) {
        $this->data->setEtat('Annulée');
        $this->em->persist($data);
        $this->em->flush();
    }
}
