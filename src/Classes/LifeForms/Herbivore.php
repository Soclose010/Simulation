<?php

namespace App\Classes\LifeForms;

use App\Classes\Core\Coordinate;
use App\Classes\Core\Map\MapInterface;
use App\Classes\Core\PathAlgorithms\PathAlgorithmInterface;
use App\Classes\Core\Printer\PrinterInterface;
use App\Classes\LifeForms\Food\Food;
use App\Classes\LifeForms\Food\HerbivoreEatable;
use App\Classes\LifeForms\Food\PredatorEatable;

class Herbivore extends Creature implements PredatorEatable
{
    public function __construct(int $weight, int $speed, int $hp, Coordinate $coordinate, MapInterface $map, PrinterInterface $printer, PathAlgorithmInterface $algorithm)
    {
        parent::__construct($weight, $speed, $hp, $coordinate, $map, $printer);
        $this->algorithm = $algorithm;
        $this->target = HerbivoreEatable::class;
        $this->visual = "🐇";
        $this->name = "заяц";
    }

    protected function Interact(Entity $target): void
    {
        if ($this->haveSteps()) {
            $this->printer->eat($this->remainingSteps, $target->getWeight());
            $this->Eat($target);
        } else {
            $this->noFood();
        }
    }

    protected function Eat(Food $target): void
    {
        $this->remainingSteps--;
        $this->haveFood();
        $target->Eaten();
    }
}