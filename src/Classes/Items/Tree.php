<?php

namespace App\Classes\Items;

use App\Classes\Core\Coordinate;
use App\Classes\LifeForms\Entity;

class Tree extends Entity
{

    public function __construct(Coordinate $coordinate)
    {
        parent::__construct($coordinate);
    }
}