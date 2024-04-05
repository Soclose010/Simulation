<?php

namespace App\Classes\Core\PathAlgorithms;
interface PathAlgorithmInterface
{

    public function findNearest(string $target) : array;
}