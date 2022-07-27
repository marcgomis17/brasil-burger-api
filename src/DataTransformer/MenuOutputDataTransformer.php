<?php

namespace App\DataTransformer;

use App\Entity\Menu;
use App\DTO\MenuOutput;
use App\DTO\MenuBurgerOutput;
use App\Entity\MenuPortionFrite;
use App\Entity\MenuTailleBoisson;
use App\DTO\MenuTailleBoissonOutput;
use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\DTO\MenuPortionFriteOutput;

final class MenuOutputDataTransformer implements DataTransformerInterface {
    private Menu $menu;
    public MenuBurgerOutput $menuBurgers;
    public MenuTailleBoissonOutput $MenuTailles;
    public MenuPortionFriteOutput $menuFrites;


    public function supportsTransformation($data, string $to, array $context = []): bool {
        return MenuOutput::class === $to && $data instanceof Menu;
    }

    public function transform($object, string $to, array $context = []) {
        $output = new MenuOutput($this->menu, $this->menuBurgers, $this->menuTailles, $this->menuFrites);
        $output->id = $object->getId();
        $output->nom = $object->getNom();
        $output->prix = $object->getPrix();
        $output->image = $object->getImage();
        return $output;
    }
}
