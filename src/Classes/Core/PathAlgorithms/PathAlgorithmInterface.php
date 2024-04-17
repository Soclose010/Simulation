<?php

namespace App\Classes\Core\PathAlgorithms;

use App\Classes\Core\Coordinate;
use App\Classes\Core\Exceptions\NotFoundException;

interface PathAlgorithmInterface
{

    /**
     * @throws NotFoundException
     */
    public function findNearest(Coordinate $coordinate, string $target): array;
}