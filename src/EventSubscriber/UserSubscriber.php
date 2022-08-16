<?php

namespace App\EventSubscriber;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\HttpFoundation\RequestStack;

final class UserSubscriber {

    public function __construct(RequestStack $requestStack) {
        $this->request = $requestStack;
    }

    public function onJWTCreated(JWTCreatedEvent $event) {
        $payload = $event->getData();
        $user = $event->getUser();
        $userArr = ['prenom' => $user->getPrenom(), 'nom' => $user->getNom()];
        $payload['user'] = $userArr;
        $event->setData($payload);
        $header = $event->getHeader();
        $event->setHeader($header);
    }
}
