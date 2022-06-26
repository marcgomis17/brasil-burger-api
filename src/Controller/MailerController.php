<?php

namespace App\Controller;

use DateInterval;
use DateTime;
use Exception;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MailerController extends AbstractController {
    #[Route('/mailer', name: 'app_mailer')]
    public function sendEmail(MailerInterface $mailer) {
        $email = new TemplatedEmail();
        $email->from(new Address('brasil@burger.com', 'Brasil burger'))
            ->subject('Confirmation de compte Brasil burger')
            ->to(new Address('marcgomis74@gmail.com', 'Marc Gomis'))
            ->htmlTemplate('mailer/email.html.twig')
            ->context([
                'expiration_date' => date_add(new DateTime(), new DateInterval("PT20M")),
                'toName' => "cdsc",
                'username' => 'Brasil burger'
            ]);
        try {
            $mailer->send($email);
        } catch (Exception $e) {
            dd($e->getMessage());
        }
        return new Response('Mail sent successfuly');
    }
}
