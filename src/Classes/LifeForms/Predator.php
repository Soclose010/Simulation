<?php

namespace App\Classes\LifeForms;

use App\Classes\Core\Coordinate;
use App\Classes\Core\Map\MapInterface;
use App\Classes\Core\PathAlgorithms\PathAlgorithmInterface;

class Predator extends Creature implements PredatorEatable
{
    private int $power;
    public function __construct(int $speed, int $hp, int $power, Coordinate $coordinate, MapInterface $map, PathAlgorithmInterface $algorithm)
    {
        $this->speed = $speed;
        $this->hp = $hp;
        $this->power = $power;
        $this->coordinate = $coordinate;
        $this->map = $map;
        $this->algorithm = $algorithm;
        $this->hunger = false;
        $this->target = PredatorEatable::class;
    }
    public function Turn(bool $isEat, int $remainingSteps): void
    {
        $this->remainingSteps = $remainingSteps;
        [$stepsNeeded, $targetCord, $creatureCord] = $this->algorithm->findNearest($this->target);
        $this->Move($isEat, $stepsNeeded, $creatureCord);
        $this->Fight($isEat, $targetCord);
    }

    private function Fight(bool $isEat, Coordinate $targetCord): void
    {
        if ($this->remainingSteps == 0)
        {
            return;
        }
        $target = $this->map->getEntity($targetCord);
        $targetHp = $target->getHp();
        while ($this->remainingSteps > 0 && $targetHp > 0)
        {
            $this->remainingSteps--;
            $targetHp-=$this->power;
        }

        if ($targetHp > 0)
        {
            $this->noFood($isEat);
            return;
        }
        $this->Eat($target);
    }

    private function Eat(Entity $target): void
    {
        $this->haveFood();
        $this->map->remove($target);
        if ($this->remainingSteps > 0)
        {
            $this->Turn(true, $this->remainingSteps);
        }
    }
}