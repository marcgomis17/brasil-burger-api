<?php

namespace App\DataPersister;

use App\Entity\User;
use App\Entity\Client;
use App\Entity\Livreur;
use App\Service\Hasher;
use App\Service\Mailer;
use App\Entity\Gestionnaire;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;

class UserPersister implements DataPersisterInterface {
    private $manager;
    private $hasher;
    private $mailer;

    public function __construct(Hasher $hasher, EntityManagerInterface $entityManager, Mailer $mailer) {
        $this->hasher = $hasher;
        $this->manager = $entityManager;
        $this->mailer = $mailer;
    }

    public function supports($data): bool {
        return $data instanceof User;
    }

    public function persist($data) {
        $data->setPassword($this->hasher->hashPassword($data, $data->getPlainPassword()));
        $data->generateToken();
        if ($data instanceof Gestionnaire || $data instanceof Livreur) {
            $data->setToken('');
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
