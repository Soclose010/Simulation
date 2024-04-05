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

    public function Turn(bool $isEat, int $remainingSteps): void
    {
        $this->remainingSteps = $remainingSteps;
        [$stepsNeeded, $targetCord, $creatureCord] = $this->algorithm->findNearest($this->target, $this->remainingSteps);
        $this->Move($isEat, $stepsNeeded, $creatureCord);
        $this->Eat($isEat, $targetCord);
    }

    private function Move(bool $isEat, int $stepsNeeded, Coordinate $creatureCord): void
    {
        if ($this->remainingSteps < $stepsNeeded)
        {
            $this->noFood($isEat);
            return;
        }
        $this->remainingSteps-=$stepsNeeded;
        $this->coordinate = $creatureCord;
    }

    private function Eat(bool $isEat, Coordinate $targetCord): void
    {
        if ($this->remainingSteps > 0)
        {
            $this->EatGrass($targetCord);
            if ($this->remainingSteps > 0)
            {
                $this->Turn(true, $this->remainingSteps);
            }
        }
        else
        {
            $this->noFood($isEat);
        }
    }
    private function EatGrass(Coordinate $coordinate): void
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