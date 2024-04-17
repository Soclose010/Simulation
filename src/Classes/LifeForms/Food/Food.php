<?php

namespace App\Classes\LifeForms\Food;

use App\Classes\Core\Coordinate;
use App\Classes\LifeForms\Entity;

abstract class Food extends Entity implements Eatable
{
    private int $weight;
    private int $decay;

    public function __construct(Coordinate $coordinate, int $weight)
    {
        parent::__construct($coordinate);
        $this->weight = $weight;
        $this->decay = 0;
    }

    public function addDecay(): void
    {
        $this->decay++;
    }

    public function spoiled(): bool
    {
        return $this->decay >= $this->weight;
    }

    public function getWeight(): int
    {
        return $this->weight;
    }

    public function haveWeight(): bool
    {
        return $this->getWeight() > 0;
    }

    public function Eaten(): void
    {
        $this->weight--;
    }


}