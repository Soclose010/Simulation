<?php

namespace App\Classes\LifeForms;
use App\Classes\Core\Coordinate;
use App\Classes\Core\Map\MapInterface;
use App\Classes\Core\PathAlgorithms\PathAlgorithmInterface;
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

    public function __construct(int $weight, int $speed, int $hp, Coordinate $coordinate, MapInterface $map)
    {
        parent::__construct($coordinate, $weight);
        $this->speed = $speed;
        $this->hp = $hp;
        $this->hunger = false;
        $this->coordinate = $coordinate;
        $this->map = $map;
        $this->isEat = false;
    }

    abstract public function Turn(int $remainingSteps);
    abstract protected function Interact(Entity $target);
    abstract protected function Eat(Food $target);

    protected function Move(array $steps): void
    {
        if ($this->remainingSteps < count($steps) - 1)
        {
            $this->map->move($this, $steps[$this->remainingSteps]);
            $this->noFood();
            $this->remainingSteps = 0;
            return;
        }
        $this->remainingSteps-= count($steps) - 1;
        $this->map->move($this, end($steps));
    }

    protected function haveFood(): void
    {
        $this->isEat = true;
        if (!$this->hunger)
        {
            $this->hp++;
        }
        else
        {
            $this->hunger = false;
        }
    }

    protected function noFood(): void
    {
        if (!$this->isEat)
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

    protected function keepTurn(): void
    {
        if ($this->haveSteps())
        {
            $this->Turn($this->remainingSteps);
        }
    }
    protected function haveSteps() : bool
    {
        if ($this->remainingSteps = 0)
        {
            $this->noFood();
            return false;
        }
        return true;
    }

    protected function isAlive(): bool
    {
        return $this->hp > 0;
    }
    public function haveAttacked(int $power): void
    {
        $this->hp-=$power;
    }

    public function changeTarget(string $newTarget): void
    {
        $this->target = $newTarget;
    }
    public function getSpeed(): int
    {
        return $this->speed;
    }

    public function getHp(): int
    {
        return $this->hp;
    }


}