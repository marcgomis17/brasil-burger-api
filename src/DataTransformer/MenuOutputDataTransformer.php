<?php

namespace App\DataTransformer;

use App\Entity\Menu;
use App\DTO\MenuOutput;
use App\DTO\MenuBurgerOutput;
use ApiPlatform\Core\DataTransformer\DataTransformerInterface;

final class MenuOutputDataTransformer implements DataTransformerInterface {
    private Menu $menu;
    private MenuBurgerOutput $menuBurgers;

    public function supportsTransformation($data, string $to, array $context = []): bool {
        return Menu::class === $to && $data instanceof Menu;
    }

    public function transform($object, string $to, array $context = []) {
        $output = new MenuOutput($this->menu, $this->menuBurgers);
        $output->id = $object->getId();
        $output->nom = $object->getNom();
        $output->prix = $object->getPrix();
        $output->image = $object->getImage();
        return $output;
    }
}
