<?php

namespace App\DTO;

final class MenuPortionFriteOutput {
    public int $id;
    public int $quantite;
    public PortionFriteMenuIO $portionFrite;

    public function __construct(PortionFriteMenuIO $portion) {
        $this->portionFrite = $portion;
    }
}
