<?php

namespace App\DTO;

final class MenuPortionFriteInput {
    public int $quantite;
    public PortionFriteMenuIO $portionFrite;

    public function __construct(PortionFriteMenuIO $portionFrite) {
        $this->portionFrite = $portionFrite;
    }
}
