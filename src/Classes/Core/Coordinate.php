<?php

namespace App\Classes\Core;

class Coordinate
{
    private int $x;
    private int $y;

    private ?Coordinate $parent;


    public function __construct(int $x, int $y)
    {
        $this->x = $x;
        $this->y = $y;
        $this->parent = null;
    }

    public function getStringCords(): string
    {
        return "{$this->x}:{$this->y}";
    }

    public function getArrayCords(): array
    {
        return [$this->x, $this->y];
    }

    public function getParent(): ?Coordinate
    {
        return $this->parent;
    }

    public function setParent(?Coordinate $parent): void
    {
        $this->parent = $parent;
    }
}