<?php

namespace App\Classes\Core\PathAlgorithms;

use App\Classes\Core\Coordinate;
use App\Classes\Core\Exceptions\NotFoundException;
use App\Classes\Core\Map\MapInterface;
use App\Classes\LifeForms\Entity;

class BFS implements PathAlgorithmInterface
{
    private MapInterface $map;
    /**
     * @var Coordinate[]
     */
    private array $queue = [];

    /**
     * @var Coordinate[]
     */
    private array $visited = [];

    public function __construct(MapInterface $map)
    {
        $this->map = $map;
    }

    /**
     * @throws NotFoundException
     */
    public function findNearest(Coordinate $coordinate, string $target): array
    {
        $this->clear();
        $this->queue[] = $coordinate;
        $isFound = false;
        /** @var ?Entity $searchedEntity */
        $searchedEntity = null;
        while ($this->queue != [] && !$isFound) {
            [$isFound, $searchedEntity] = $this->find($target);
        }
        if ($isFound) {
            return [$this->calcSteps($this->visited[array_key_last($this->visited)]), $searchedEntity];
        }
        throw new NotFoundException();
    }

    private function find(string $target): array
    {
        $entityCord = array_pop($this->queue);
        $this->visited[] = $entityCord;
        if ($this->map->isEntity($entityCord)) {
            $entity = $this->map->getEntityByCords($entityCord);
            if ($this->isNeeded($entity, $target)) {
                return [true, $entity];
            }
        }
        [$startI, $endI, $startJ, $endJ] = $this->map->getBoundariesByCords($entityCord);
        for ($i = $startI; $i <= $endI; $i++) {
            for ($j = $startJ; $j <= $endJ; $j++) {
                $cord = new Coordinate($i, $j);
                if (!$this->inQueue($cord) && !$this->isVisited($cord)) {
                    if ($this->map->isEntity($cord)) {
                        $entity = $this->map->getEntityByCords($cord);
                        if ($this->isNeeded($entity, $target)) {
                            $this->addToQueue($cord, $entityCord);
                        }
                    } else {
                        $this->addToQueue($cord, $entityCord);
                    }
                }
            }
        }
        return [false, null];
    }

    private function addToQueue(Coordinate $coordinate, Coordinate $parentCords): void
    {
        array_unshift($this->queue, $coordinate);
        $coordinate->setParent($parentCords);
    }

    private function isNeeded(Entity $entity, string $target): bool
    {
        return $entity instanceof $target && $entity->haveWeight();
    }

    private function calcSteps(Coordinate $targetCords): array
    {
        $steps = [];
        $currentCords = $targetCords;
        while (!is_null($currentCords->getParent())) {
            $tmp = $currentCords->getParent();
            array_unshift($steps, $tmp);
            $currentCords = $tmp;
        }
        array_shift($steps);
        return $steps;
    }

    private function inQueue(Coordinate $coordinate): bool
    {
        $entityCords = $coordinate->getStringCords();
        foreach ($this->queue as $item) {
            if ($item->getStringCords() === $entityCords) {
                return true;
            }
        }
        return false;
    }

    private function isVisited(Coordinate $coordinate): bool
    {
        $entityCords = $coordinate->getStringCords();
        foreach ($this->visited as $item) {
            if ($item->getStringCords() === $entityCords) {
                return true;
            }
        }
        return false;
    }

    private function clear(): void
    {
        $this->queue = [];
        $this->visited = [];
    }

}