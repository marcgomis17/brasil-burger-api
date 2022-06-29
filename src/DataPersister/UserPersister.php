<?php

namespace App\DataPersister;

use App\Entity\User;
use App\Entity\Client;
use App\Service\Mailer;
use App\Entity\Gestionnaire;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserPersister implements DataPersisterInterface {
    private $manager;
    private $hasher;
    private $mailer;

    public function __construct(UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager, Mailer $mailer) {
        $this->hasher = $passwordHasher;
        $this->manager = $entityManager;
        $this->mailer = $mailer;
    }

    public function supports($data): bool {
        return $data instanceof User;
    }

    public function persist($data) {
        $data->setPassword($this->hasher->hashPassword($data, $data->getPassword()));
        $data->generateToken();
        if ($data instanceof Gestionnaire) {
            $data->setIsVerified(true);
        }
        $this->manager->persist($data);
        $this->manager->flush();
        $username = $data->getPrenom() . ' ' . $data->getNom();
        if ($data instanceof Client) {
            $this->mailer->sendEmail($data->getEmail(), $data->getToken(), $username, $data->getExpireAt());
        }
    }

    public function remove($data) {
    }
}
