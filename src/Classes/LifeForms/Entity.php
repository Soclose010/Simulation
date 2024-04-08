<?php

namespace App\Classes\LifeForms;
use App\Classes\Core\Coordinate;

abstract class Entity
{

    protected Coordinate $coordinate;

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
}