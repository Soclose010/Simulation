<?php

namespace App\Classes\LifeForms\Food;

use App\Classes\LifeForms\Entity;

abstract class Food extends Entity
{
    private int $weight;

    public function __construct(int $weight)
    {
        $this->weight = $weight;
    }
}