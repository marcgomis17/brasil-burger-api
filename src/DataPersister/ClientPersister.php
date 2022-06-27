<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Client;
use App\Service\Mailer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ClientPersister implements DataPersisterInterface {
    private $manager;
    private $hasher;
    private $mailer;

    public function __construct(UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager, Mailer $mailer) {
        $this->hasher = $passwordHasher;
        $this->manager = $entityManager;
        $this->mailer = $mailer;
    }

    public function supports($data): bool {
        return $data instanceof Client;
    }

    public function persist($data) {
        $data->setPassword($this->hasher->hashPassword($data, $data->getPassword()));
        $data->generateToken();
        $this->manager->persist($data);
        $this->manager->flush();
        $username = $data->getPrenom() . ' ' . $data->getNom();
        $this->mailer->sendEmail($data->getEmail(), $data->getToken(), $username, $data->getExpireAt());
    }

    public function remove($data) {
    }
}
