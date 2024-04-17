<?php

namespace App\Classes\Core\Map;

use App\Classes\Core\Coordinate;
use App\Classes\LifeForms\Entity;

interface MapInterface
{
    public function add(Entity $entity): void;

    public function move(Entity $entity, Coordinate $coordinate);

    public function getEntityByCords(Coordinate $coordinate): ?Entity;

    public function getBoundariesByCords(Coordinate $coordinate): array;

    public function getBoundaries(): array;

    public function isEntity(Coordinate $coordinate): bool;

    public function getCreatures(): array;

    public function clear(): void;

    public function clearCords(): void;

    public function haveAliveCreatures(): bool;
}