<?php

namespace App\Classes\LifeForms;

class Herbivore extends Creature
{

    public function __construct(int $hp, int $speed)
    {
        $this->hp = $hp;
        $this->speed = $speed;
    }

    public function makeMove()
    {

    }
}