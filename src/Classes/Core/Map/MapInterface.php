<?php

namespace App\Classes\Core\Map;

use App\Classes\Core\Coordinate;
use App\Classes\LifeForms\Entity;
use App\Classes\LifeForms\Food\Food;

interface MapInterface
{
    public function remove(Entity $entity) : void;
    public function add(Entity $entity): void;

    public function newTurn(): void;

}