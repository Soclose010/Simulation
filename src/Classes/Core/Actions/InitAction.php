<?php

namespace App\Classes\Core\Actions;

use App\Classes\Core\Coordinate;
use App\Classes\Core\Map\MapInterface;
use App\Classes\Core\PathAlgorithms\BFS;
use App\Classes\Core\Printer\PrinterInterface;
use App\Classes\Items\Grass;
use App\Classes\Items\Rock;
use App\Classes\LifeForms\Herbivore;
use App\Classes\LifeForms\Predator;

class InitAction implements ActionInterface
{
    private MapInterface $map;
    private PrinterInterface $printer;

    public function __construct(MapInterface $map, PrinterInterface $printer)
    {
        $this->map = $map;
        $this->printer = $printer;
    }

    public function make(): void
    {
        $this->fillMap();
    }

    private function fillMap(): void
    {
        [$startI, $endI, $startJ, $endJ] = $this->map->getBoundaries();
        $this->fillCreatures($startI, $endI, $startJ, $endJ);
        $this->fillGrass($startI, $endI, $startJ, $endJ);
        $this->fillObstacles($startI, $endI, $startJ, $endJ);
    }

    private function fillObstacles(int $startI, int $endI, int $startJ, int $endJ): void
    {
        $count = rand(10, 15);
        while ($count > 0) {
            $obstacleNumber = rand(1, 2);
            $cord = new Coordinate(rand($startI, $endI), rand($startJ, $endJ));
            switch ($obstacleNumber) {
                case 1:
                    $rock = new Rock($cord);
                    $this->map->add($rock);
                    break;
                case 2:
                    $tree = new Rock($cord);
                    $this->map->add($tree);
                    break;
            }
            $count--;
        }
    }

    private function fillGrass(int $startI, int $endI, int $startJ, int $endJ): void
    {
        $count = rand(5, 10);
        while ($count > 0) {
            $cord = new Coordinate(rand($startI, $endI), rand($startJ, $endJ));
            $grass = new Grass($cord, rand(1, 3));
            $this->map->add($grass);
            $count--;
        }
    }

    private function fillCreatures(int $startI, int $endI, int $startJ, int $endJ): void
    {
        $countHerb = rand(3, 5);
        $countPred = rand(1, 2);
        $algo = new BFS($this->map);
        while ($countHerb > 0) {
            $cord = new Coordinate(rand($startI, $endI), rand($startJ, $endJ));
            $herb = new Herbivore(rand(1, 2), 2, 2, $cord, $this->map, $this->printer,$algo);
            $this->map->add($herb);
            $countHerb--;
        }

        while ($countPred > 0) {
            $cord = new Coordinate(rand($startI, $endI), rand($startJ, $endJ));
            $pred = new Predator(rand(2, 5), 5, 3, 1, $cord, $this->map, $this->printer,$algo);
            $this->map->add($pred);
            $countPred--;
        }
    }
}