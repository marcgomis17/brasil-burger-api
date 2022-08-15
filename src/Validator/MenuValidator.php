<?php

namespace App\Validator;

use Symfony\Component\Validator\Context\ExecutionContextInterface;

class MenuValidator {
    public static function validate($object, ExecutionContextInterface $context, $payload) {
        if (count($object->getMenuFrites()) == 0 && count($object->getMenuTailles()) === 0) {
            $context->buildViolation("Le menu doit avoir au moins un complément (boisson ou frite)!!")
                ->addViolation();
        }
    }
}
