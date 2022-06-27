<?php

namespace App\Controller;

use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConfirmationController extends AbstractController {
    #[Route('/confirmation/{token}', name: 'app_confirmation')]
    public function confirmAccount(ClientRepository $repo, string $token, EntityManagerInterface $manager) {
        $user = $repo->findOneBy(['token' => $token]);
        if ($user) {
            $user->setIsVerified(true)
                ->setToken("");
            $manager->persist($user);
            $manager->flush();
            return new Response('Votre compte a été confirmé avec succès!! <br/>Vous pouvez maintenant vous connecter.');
        } else {
            return new Response("Échec de la confirmation du mail");
        }
    }
}
