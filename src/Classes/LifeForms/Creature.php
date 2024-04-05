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
    abstract public function makeActions(bool $isEat, int $remainingSteps);
    public function getSpeed(): int
    {
        return $this->speed;
    }
}