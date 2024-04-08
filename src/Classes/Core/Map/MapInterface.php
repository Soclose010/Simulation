<?php

namespace App\Classes\Core\Map;

use App\Classes\Core\Coordinate;
use App\Classes\LifeForms\Entity;
interface MapInterface
{
    public function remove(Entity $entity) : void;
    public function add(Entity $entity): void;

    public function newTurn(): void;

    public function move(Entity $entity, Coordinate $coordinate);

    public function getEntityByCords(Coordinate $coordinate) : Entity;

    public function getEntityBoundaries(Entity $entity) : array;

}