<?php

namespace App\Classes\Core\Map;

use App\Classes\Core\Coordinate;
use App\Classes\LifeForms\Entity;
use App\Classes\LifeForms\Food\Food;

class Map implements MapInterface
{
    /**
     * @var Entity[]
     */
    private array $entities = [];

    private Coordinate $start;

    private Coordinate $end;

    public function __construct(Coordinate $start, Coordinate $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public function remove(Entity $entity): void
    {
        $this->entities = array_filter($this->entities, function ($ent) use ($entity) {
            return $ent->getCoordinate()->getStringCords() === $entity->getCoordinate()->getStringCords();
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

    public function move(Entity $entity, Coordinate $coordinate): void
    {
        $entity->setCoordinate($coordinate);
    }

    public function getEntityByCords(Coordinate $coordinate): Entity
    {
        return array_filter($this->entities, function ($entity) use ($coordinate)
        {
            return $entity->getCoordinate()->getStringCords() === $coordinate->getStringCords();
        })[0];
    }

    public function getEntityBoundaries(Entity $entity): array
    {
        $startCords = $this->start->getArrayCords();
        $endCords = $this->end->getArrayCords();
        $entityCords = $entity->getCoordinate()->getArrayCords();
        $cordsCount = count($startCords);
        $resCords = [];
        for ($i = 0; $i < $cordsCount; $i++)
        {
            $resCords = array_merge($resCords, $this->getCordWithBoundaries($startCords[$i], $endCords[$i], $entityCords[$i]));
        }
        return $resCords;
    }

    private function getCordWithBoundaries(int $startCord, int $endCord, int $entityCord) : array
    {
        $res = [];
        if ($entityCord > $startCord)
        {
            $res[] = $entityCord - 1;
        }
        else
        {
            $res = $startCord;
        }
        if ($entityCord < $endCord)
        {
            $res[] = $entityCord + 1;
        }
        else
        {
            $res = $entityCord;
        }
        return $res;
    }
}