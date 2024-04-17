<?php

namespace App\Classes\Core\Map;

use App\Classes\Core\Coordinate;
use App\Classes\LifeForms\Creature;
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


    public function add(Entity $entity): void
    {
        if (!$this->isEntity($entity->getCoordinate())) {
            $this->entities[] = $entity;
        }
    }

    public function clear(): void
    {
        $this->entities = array_filter($this->entities, function ($entity) {
            if ($entity instanceof Food) {
                return $entity->haveWeight() && !$entity->spoiled();
            }
            return true;
        });

        foreach ($this->entities as $entity) {
            if ($entity instanceof Creature && !$entity->isAlive()) {
                $entity->visualizeDead();
            }
        }
    }

    public function move(Entity $entity, Coordinate $coordinate): void
    {
        $entity->setCoordinate($coordinate);
    }

    public function getEntityByCords(Coordinate $coordinate): ?Entity
    {
        $entity = array_filter($this->entities, function ($entity) use ($coordinate) {
            return $entity->getCoordinate()->getStringCords() === $coordinate->getStringCords();
        });
        return array_pop($entity);
    }

    public function getBoundariesByCords(Coordinate $coordinate): array
    {
        $startCords = $this->start->getArrayCords();
        $endCords = $this->end->getArrayCords();
        $entityCords = $coordinate->getArrayCords();
        $cordsCount = count($startCords);
        $resCords = [];
        for ($i = 0; $i < $cordsCount; $i++) {
            $resCords = array_merge($resCords, $this->getCordWithBoundaries($startCords[$i], $endCords[$i], $entityCords[$i]));
        }
        return $resCords;
    }

    private function getCordWithBoundaries(int $startCord, int $endCord, int $entityCord): array
    {
        $res = [];
        if ($entityCord > $startCord) {
            $res[] = $entityCord - 1;
        } else {
            $res[] = $startCord;
        }
        if ($entityCord < $endCord) {
            $res[] = $entityCord + 1;
        } else {
            $res[] = $entityCord;
        }
        return $res;
    }

    public function getBoundaries(): array
    {
        $startCords = $this->start->getArrayCords();
        $endCords = $this->end->getArrayCords();
        $cordsCount = count($startCords);
        $resCords = [];
        for ($i = 0; $i < $cordsCount; $i++) {
            $resCords = array_merge($resCords, [$startCords[$i], $endCords[$i]]);
        }
        return $resCords;
    }

    public function isEntity(Coordinate $coordinate): bool
    {
        foreach ($this->entities as $entity) {
            if ($entity->getCoordinate()->getStringCords() === $coordinate->getStringCords()) {
                return true;
            }
        }
        return false;
    }

    /**
     * @return Creature[]
     */
    public function getCreatures(): array
    {
        return array_filter($this->entities, function ($entity) {
            return $entity instanceof Creature;
        });
    }

    public function clearCords(): void
    {
        foreach ($this->entities as $entity) {
            $entity->clearCordParent();
        }
    }

    public function haveAliveCreatures(): bool
    {
        foreach ($this->entities as $entity) {
            if ($entity instanceof Creature && $entity->isAlive()) {
                return true;
            }
        }
        return false;
    }
}