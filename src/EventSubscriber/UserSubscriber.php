<?php

namespace App\EventSubscriber;

use App\Entity\Client;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

final class UserSubscriber {
    private UserRepository $repo;

    public function __construct(UserRepository $userRepository) {
        $this->repo = $userRepository;
    }

    public function onJWTCreated(JWTCreatedEvent $event) {
        $payload = $event->getData();
        $user = $event->getUser();
        $userObj = $this->repo->findOneBy(['email' => $user->getUserIdentifier()]);
        $userArr = ['id' => $userObj->getId(), 'prenom' => $user->getPrenom(), 'nom' => $user->getNom()];
        $payload['user'] = $userArr;
        $event->setData($payload);
        $header = $event->getHeader();
        $event->setHeader($header);
    }
}
