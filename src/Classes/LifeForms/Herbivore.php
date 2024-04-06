<?php

namespace App\Classes\LifeForms;

use App\Classes\Core\Coordinate;
use App\Classes\Core\Map\MapInterface;
use App\Classes\Core\PathAlgorithms\PathAlgorithmInterface;
use App\Classes\LifeForms\Food\Food;
use App\Classes\LifeForms\Food\HerbivoreEatable;
use App\Classes\LifeForms\Food\PredatorEatable;

class Herbivore extends Creature implements PredatorEatable
{
    public function __construct(int $weight, int $speed, int $hp, Coordinate $coordinate, MapInterface $map, PathAlgorithmInterface $algorithm)
    {
        parent::__construct($weight,$speed ,$hp,$coordinate,$map);
        $this->algorithm = $algorithm;
        $this->target = HerbivoreEatable::class;
    }

    public function Turn(int $remainingSteps): void
    {
        $this->remainingSteps = $remainingSteps;
        [$steps, $target] = $this->algorithm->findNearest($this->target);
        $this->Move($steps);
        $this->Interact($target);
        $this->keepTurn();
    }

    protected function Interact(Entity $target): void
    {
        if ($this->haveSteps())
        {
            $this->Eat($target);
        }
        else
        {
            $this->noFood();
        }
    }
    protected function Eat(Food $target): void
    {
        $this->haveFood();
        $this->map->eat($target);
    }
}