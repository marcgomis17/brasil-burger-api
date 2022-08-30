<?php

namespace App\IService;

interface IMailer {
    public function sendEmail(string $emailAdress, string $token, string $username, $expirationDate);
}
