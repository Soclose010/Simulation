<?php

namespace App\Classes\LifeForms;

use App\Classes\Core\Coordinate;
use App\Classes\Core\Exceptions\NotFoundException;
use App\Classes\Core\Map\MapInterface;
use App\Classes\Core\PathAlgorithms\PathAlgorithmInterface;
use App\Classes\Core\Printer\PrinterInterface;
use App\Classes\LifeForms\Food\Food;

abstract class Creature extends Food
{
    protected int $speed;
    protected int $hp;
    protected bool $hunger;
    protected string $target;
    protected Coordinate $coordinate;
    protected MapInterface $map;
    protected PathAlgorithmInterface $algorithm;
    protected int $remainingSteps;
    protected bool $isEat;
    protected PrinterInterface $printer;

    public function __construct(int $weight, int $speed, int $hp, Coordinate $coordinate, MapInterface $map, PrinterInterface $printer)
    {
        parent::__construct($coordinate, $weight);
        $this->speed = $speed;
        $this->hp = $hp;
        $this->hunger = true;
        $this->coordinate = $coordinate;
        $this->map = $map;
        $this->isEat = false;
        $this->remainingSteps = $speed;
        $this->printer = $printer;
    }


    public function Turn(): void
    {
        try {
            [$steps, $target] = $this->algorithm->findNearest($this->coordinate, $this->target);
            /**
             * @var Entity $target
             */
            $this->printer->activeEntityInfo($this->name, $this->hp, $this->hunger, $this->coordinate);
            $this->printer->move($target->getName(), $this->remainingSteps, $target->getCoordinate(), $steps);
            $this->Move($steps);
            $this->Interact($target);
        } catch (NotFoundException) {
            $this->printer->noTarget($this->name, $this->coordinate, $this->hp);
            $this->noFood();
            $this->remainingSteps = 0;
        }
    }

    abstract protected function Interact(Entity $target);

    abstract protected function Eat(Food $target);

    protected function Move(array $steps): void
    {
        if (count($steps) == 0) {
            return;
        }
        if ($this->remainingSteps <= count($steps)) {
            $this->map->move($this, $steps[$this->remainingSteps - 1]);
            $this->remainingSteps = 0;
            return;
        }
        $this->remainingSteps -= count($steps);
        $this->map->move($this, $steps[array_key_last($steps)]);
    }

    protected function haveFood(): void
    {
        $this->isEat = true;
        if (!$this->hunger) {
            $this->hp++;
        } else {
            $this->hunger = false;
        }
    }

    protected function noFood(): void
    {
        if (!$this->isEat) {
            if ($this->hunger) {
                $this->hp--;
            } else {
                $this->hunger = true;
            }
        }
    }

    public function haveSteps(): bool
    {
        return $this->remainingSteps != 0;
    }

    public function isAlive(): bool
    {
        return $this->hp > 0;
    }

    public function haveAttacked(int $power): void
    {
        $this->hp -= $power;
    }

    public function clear(): void
    {
        $this->remainingSteps = $this->speed;
        $this->isEat = false;
        $this->hunger = true;
    }

    public function getHp(): int
    {
        return $this->hp;
    }

}