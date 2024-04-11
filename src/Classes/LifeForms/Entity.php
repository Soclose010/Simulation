<?php

namespace App\Classes\LifeForms;
use App\Classes\Core\Coordinate;

abstract class Entity
{
    protected Coordinate $coordinate;
    protected string $visual;

    protected string $name;

    public function __construct(Coordinate $coordinate)
    {
        $this->coordinate = $coordinate;
    }
    public function getCoordinate(): Coordinate
    {
        return $this->coordinate;
    }
    public function setCoordinate(Coordinate $coordinate): void
    {
        $this->coordinate = $coordinate;
    }
    public function visualize(): string
    {
        return $this->visual;
    }

    public function visualizeDead(): void
    {
        $this->visual = "🥩";
    }
    public function getName(): string
    {
        return $this->name;
    }
}