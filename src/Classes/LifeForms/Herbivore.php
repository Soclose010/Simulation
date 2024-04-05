<?php

namespace App\Classes\LifeForms;

use App\Classes\Core\Coordinate;
use App\Classes\Core\Map\MapInterface;
use App\Classes\Core\PathAlgorithms\PathAlgorithmInterface;

class Herbivore extends Creature
{
    public function __construct(int $speed, int $hp, Coordinate $coordinate, MapInterface $map, PathAlgorithmInterface $algorithm)
    {
        $this->speed = $speed;
        $this->hp = $hp;
        $this->hunger = false;
        $this->coordinate = $coordinate;
        $this->map = $map;
        $this->algorithm = $algorithm;
    }

    public function makeActions(bool $isEat, int $remainingSteps): void
    {
        $this->remainingSteps = $remainingSteps;
        [$stepsNeeded, $targetCord, $creatureCord] = $this->algorithm->findNearest($this->target, $this->remainingSteps);
        $this->makeMove($isEat, $stepsNeeded, $creatureCord);
        $this->makeEat($isEat, $targetCord);
    }

    private function makeMove(bool $isEat, int $stepsNeeded, Coordinate $creatureCord): void
    {
        if ($this->remainingSteps < $stepsNeeded)
        {
            $this->noFood($isEat);
            return;
        }
        $this->remainingSteps-=$stepsNeeded;
        $this->coordinate = $creatureCord;
    }

    private function makeEat(bool $isEat, Coordinate $targetCord): void
    {
        if ($this->remainingSteps > 0)
        {
            $this->eat($targetCord);
            if ($this->remainingSteps > 0)
            {
                $this->makeActions(true, $this->remainingSteps);
            }
        }
        else
        {
            $this->noFood($isEat);
        }
    }
    private function eat(Coordinate $coordinate): void
    {
        $this->remainingSteps--;
        $this->haveFood();
        $this->map->remove($coordinate);
    }

    private function haveFood(): void
    {
        if (!$this->hunger)
        {
            $this->hp++;
        }
        else
        {
            $this->hunger = false;
        }
    }

    private function noFood(bool $isEat): void
    {
        if (!$isEat)
        {
            if ($this->hunger)
            {
                $this->hp--;
            }
            else
            {
                $this->hunger = true;
            }
        }
    }
}