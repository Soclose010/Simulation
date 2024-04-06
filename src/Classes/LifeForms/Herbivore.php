<?php

namespace App\Classes\LifeForms;

use App\Classes\Core\Coordinate;
use App\Classes\Core\Map\MapInterface;
use App\Classes\Core\PathAlgorithms\PathAlgorithmInterface;

class Herbivore extends Creature implements PredatorEatable
{
    public function __construct(int $weight, int $speed, int $hp, Coordinate $coordinate, MapInterface $map, PathAlgorithmInterface $algorithm)
    {
        parent::__construct($weight,$speed ,$hp,$coordinate,$map);
        $this->algorithm = $algorithm;
        $this->target = HerbivoreEatable::class;
    }

    public function Turn(bool $isEat, int $remainingSteps): void
    {
        $this->remainingSteps = $remainingSteps;
        [$stepsNeeded, $targetCord, $creatureCord] = $this->algorithm->findNearest($this->target);
        $this->Move($isEat, $stepsNeeded, $creatureCord);
        $this->Eat($isEat, $targetCord);
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

}