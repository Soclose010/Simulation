<?php

namespace App\Classes\Core;

abstract class Food extends Entity
{
    private int $weight;

    public function __construct(int $weight)
    {
        $this->weight = $weight;
    }
}