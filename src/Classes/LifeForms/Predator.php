<?php

namespace App\Classes\LifeForms;

class Predator extends Creature
{
    private int $power;

    public function __construct(int $hp, int $speed, int $power)
    {
        $this->hp = $hp;
        $this->speed = $speed;
        $this->power = $power;
    }

    private function attack(Creature $creature): void
    {
        $creature->damage($this->power);
    }
    public function makeMove()
    {

    }
}