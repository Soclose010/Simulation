<?php

namespace App\Classes\LifeForms;
abstract class Creature extends Entity
{
    protected int $speed;
    protected int $hp;

    abstract public function makeMove();

    public function damage(int $power): void
    {
        $this->hp-=$power;
    }
}