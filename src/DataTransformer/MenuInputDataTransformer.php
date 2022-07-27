<?php

namespace App\DataTransformer;

use App\Entity\Menu;
use ApiPlatform\Core\DataTransformer\DataTransformerInterface;

final class MenuInputDataTransformer implements DataTransformerInterface {
    public function supportsTransformation($data, string $to, array $context = []): bool {
        if ($data instanceof Menu) {
            return false;
        }
        return Menu::class === $to && null !== ($context['input']['Menu'] ?? null);
    }

    public function transform($object, string $to, array $context = []) {
        $menu = new Menu();
        $object->nom = $menu->getNom();
        $object->image = $menu->getFile();
        return $menu;
    }
}
