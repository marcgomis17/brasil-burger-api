<?php

namespace App\IService;

interface IHasher {
    public function hashPassword($object, string $password);
}
