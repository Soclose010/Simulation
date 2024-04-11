<?php

namespace App\Classes\Core\Render;

use App\Classes\Core\Coordinate;
use App\Classes\Core\Map\Map;
use App\Classes\Core\Map\MapInterface;
use App\Classes\LifeForms\Entity;

class Renderer implements RenderInterface
{
    private MapInterface $map;
    private string $space = "  ";
    private string $nothing = "👯";
    public function __construct(MapInterface $map)
    {
        $this->map = $map;
    }
    public function render(): void
    {
        [$startI, $endI, $startJ, $endJ] = $this->map->getBoundaries();
        $this->renderTop($startJ, $endJ);
        for ($i = $startI; $i <= $endI; $i++)
        {
            echo "{$i} ";
            for ($j = $startJ; $j<= $endJ; $j++)
            {
                $this->renderOne($i, $j);
            }
            echo PHP_EOL;
        }
        echo PHP_EOL;
    }

    private function renderOne(int $x, int $y): void
    {
        $cord = new Coordinate($x, $y);
        if ($this->map->isEntity($cord))
        {
            $entity = $this->map->getEntityByCords($cord);
            $this->renderEntity($entity);
        }
        else
        {
            $this->renderNothing();
        }
    }

    private function renderEntity(Entity $entity): void
    {
        echo $entity->visualize() . $this->space;
    }

    private function renderNothing(): void
    {
        echo $this->nothing . $this->space;
    }

    private function renderTop(int $start, int $end): void
    {
        echo "  ";
        for ($i = $start; $i <= $end; $i++) {
            echo " {$i}" . $this->space;
        }
        echo PHP_EOL;
    }
}