<?php

namespace App\Classes\LifeForms;

use App\Classes\Core\Coordinate;
use App\Classes\Core\Map\MapInterface;
use App\Classes\Core\PathAlgorithms\PathAlgorithmInterface;
use App\Classes\Core\Printer\PrinterInterface;
use App\Classes\LifeForms\Food\Food;
use App\Classes\LifeForms\Food\PredatorEatable;

class Predator extends Creature
{
    private int $power;

    public function __construct(int $weight, int $speed, int $hp, int $power, Coordinate $coordinate, MapInterface $map,  PrinterInterface $printer, PathAlgorithmInterface $algorithm)
    {
        parent::__construct($weight, $speed, $hp, $coordinate, $map, $printer);
        $this->power = $power;
        $this->algorithm = $algorithm;
        $this->target = PredatorEatable::class;
        $this->visual = "🐺";
        $this->name = "воук";
    }

    protected function Interact(Entity $target): void
    {
        if (!$this->haveSteps()) {
            $this->noFood();
            return;
        }
        if ($target->isAlive()) {
            $this->printer->attack($this->remainingSteps, $target->getHp());
            $this->Attack($target);
        } else {
            $this->printer->eat($this->remainingSteps, $target->getWeight());
            $this->Eat($target);
        }
    }

    private function Attack(Creature $target): void
    {
        $this->remainingSteps--;
        $target->haveAttacked($this->power);
    }

    protected function Eat(Food $target): void
    {
        $this->remainingSteps--;
        $this->haveFood();
        $target->Eaten();
    }
}