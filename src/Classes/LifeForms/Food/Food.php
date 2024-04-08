<?php

namespace App\Classes\LifeForms\Food;

use App\Classes\Core\Coordinate;
use App\Classes\LifeForms\Entity;

abstract class Food extends Entity implements Eatable
{
    private int $weight;

    public function getWeight(): int
    {
        return $this->weight;
    }

    public function Eaten(): void
    {
        $this->weight--;
    }

    public function __construct(Coordinate $coordinate, int $weight)
    {
        parent::__construct($coordinate);
        $this->weight = $weight;
    }
}