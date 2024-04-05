<?php

namespace App\Classes\LifeForms;
use App\Classes\Core\Coordinate;
use App\Classes\Core\Entity;
use App\Classes\Core\Map\MapInterface;
use App\Classes\Core\PathAlgorithms\PathAlgorithmInterface;

abstract class Creature extends Entity
{
    protected int $speed;
    protected int $hp;
    protected bool $hunger;
    protected string $target;
    protected Coordinate $coordinate;
    protected MapInterface $map;
    protected PathAlgorithmInterface $algorithm;
    protected int $remainingSteps;
    abstract public function Turn(bool $isEat, int $remainingSteps);

    protected function Move(bool $isEat, int $stepsNeeded, Coordinate $creatureCord): void
    {
        if ($this->remainingSteps < $stepsNeeded)
        {
            $this->noFood($isEat);
            return;
        }
        $this->remainingSteps-=$stepsNeeded;
        $this->coordinate = $creatureCord;
    }

    protected function haveFood(): void
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

    protected function noFood(bool $isEat): void
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
    public function getSpeed(): int
    {
        return $this->speed;
    }
}