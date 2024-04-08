<?php

namespace App\Classes\Core\PathAlgorithms;
use App\Classes\Core\Coordinate;
use App\Classes\Core\Exceptions\NotFoundException;
use App\Classes\Core\Map\MapInterface;
use App\Classes\Items\Stationary;
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
        while ($this->queue != [] && !$isFound)
        {
            [$isFound, $searchedEntity] = $this->find($target);
        }
        if ($isFound)
        {
            return [$this->calcSteps($searchedEntity->getCoordinate()), $searchedEntity];
        }
        throw new NotFoundException();
    }

    private function find(string $target): array
    {
        $entityCord = array_pop($this->queue);
        $entity = $this->map->getEntityByCords($entityCord);
        $this->visited[] = $entityCord;
        if ($this->isNeeded($entity, $target))
        {
            return [true, $entity];
        }
        [$startI, $endI, $startJ, $endJ] = $this->map->getEntityBoundaries($entity);
        for ($i = $startI; $i << $endI; $i++)
        {
            for ($j = $startJ; $j<= $endJ; $j++)
            {
                $node = $this->map->getEntityByCords(new Coordinate($i, $j));
                if (!$this->inQueue($node) && !$this->isVisited($node) && !$node instanceof Stationary)
                {
                    $this->addToQueue($node, $entityCord);
                }
            }
        }
        return [false, null];
    }

    private function addToQueue(Entity $node, Coordinate $parentCords): void
    {
        array_unshift($this->queue,$node->getCoordinate());
        $node->getCoordinate()->setParent($parentCords);
    }

    private function isNeeded(Entity $entity, string $target): bool
    {
        return $entity instanceof $target && $entity->getWeight();
    }

    private function calcSteps(Coordinate $targetCords) : array
    {
        $steps = [];
        $currentCords = $targetCords;
        while (!is_null($currentCords->getParent()))
        {
            $tmp = $currentCords->getParent();
            array_unshift($steps,$tmp);
            $currentCords = $tmp;
        }
        return $steps;
    }

    private function inQueue(Entity $node) :bool
    {
        $entityCords = $node->getCoordinate()->getStringCords();
        foreach ($this->queue as $item) {
            if ($item->getStringCords() === $entityCords)
            {
                return true;
            }
        }
        return false;
    }

    private function isVisited(Entity $node) :bool
    {
        $entityCords = $node->getCoordinate()->getStringCords();
        foreach ($this->visited as $item) {
            if ($item->getStringCords() === $entityCords)
            {
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