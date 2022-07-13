<?php

namespace App\Service;

use App\IService\IMailer;
use Exception;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;

class Mailer implements IMailer {
    private $mailer;

    public function __construct(MailerInterface $mailer) {
        $this->mailer = $mailer;
    }

    public function sendEmail(string $emailAdress, string $token, string $username, $expirationDate) {
        $email = new TemplatedEmail();
        $email->from(new Address('brasil@burger.com', 'Brasil burger'))
            ->subject('Confirmation de compte Brasil burger')
            ->to(new Address($emailAdress, $username))
            ->htmlTemplate('mailer/email.html.twig')
            ->context([
                'token' => $token,
                'expiration_date' => $expirationDate,
                'toName' => $username,
                'username' => 'Brasil burger'
            ]);
        try {
            $this->mailer->send($email);
        } catch (Exception $e) {
            dd($e->getMessage());
        }
        return new Response('Mail sent successfuly');
    }
}
