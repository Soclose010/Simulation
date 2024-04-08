<?php

namespace App\Classes\Items;
use App\Classes\Core\Coordinate;
use App\Classes\LifeForms\Food\Food;
use App\Classes\LifeForms\Food\HerbivoreEatable;

class Grass extends Food implements HerbivoreEatable
{
    public function __construct(Coordinate $coordinate, int $weight)
    {
        parent::__construct($coordinate, $weight);
    }

}