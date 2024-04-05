<?php

namespace App\Classes\Core\Map;

use App\Classes\Core\Coordinate;

interface MapInterface
{
    public function remove(Coordinate $coordinate) : void;
}