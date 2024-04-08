<?php

namespace App\Classes\Core\Map;

use App\Classes\LifeForms\Entity;
use App\Classes\LifeForms\Food\Food;

class Map implements MapInterface
{
    /**
     * @var Entity[]
     */
    private array $entities = [];

    public function remove(Entity $entity): void
    {
        $this->entities = array_filter($this->entities, function ($ent) use ($entity) {
            return $ent->getCords()->getStringCords() === $entity->getCords()->getStringCords();
        });
    }

    public function add(Entity $entity): void
    {
        $this->entities[] = $entity;
    }

    public function newTurn(): void
    {
        $this->clear();
    }

    private function clear(): void
    {
        $this->entities = array_filter($this->entities, function ($entity) {
            if ($entity instanceof Food)
            {
                return $entity->getWeight() > 0;
            }
            return true;
        });
    }
}