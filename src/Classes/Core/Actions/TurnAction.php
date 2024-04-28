<?php

namespace App\Classes\Core\Actions;

use App\Classes\Core\Map\MapInterface;
use App\Classes\Core\Printer\PrinterInterface;
use App\Classes\Core\Render\RenderInterface;
use App\Classes\LifeForms\Creature;

class TurnAction implements ActionInterface
{
    private MapInterface $map;
    private RenderInterface $renderer;
    private PrinterInterface $printer;

    public function __construct(MapInterface $map, RenderInterface $renderer, PrinterInterface $printer)
    {
        $this->map = $map;
        $this->renderer = $renderer;
        $this->printer = $printer;
    }

    public function make(): void
    {
        /** @var Creature[] $creatures */
        $creatures = $this->map->getCreatures();
        shuffle($creatures);
        foreach ($creatures as $creature) {
            while ($creature->isAlive() && $creature->haveSteps()) {
                $creature->Turn();
                $this->map->clearCords();
                $this->renderAction();
            }
            $creature->clear();
            if (!$creature->isAlive() && $creature->haveWeight()) {
                $creature->addDecay();
                $this->printer->decay($creature->getName(), $creature->getCoordinate() ,$creature->getWeight(), $creature->getDecay());
                $this->renderAction();
            }
        }
    }

    private function renderAction(): void
    {
        $this->map->clear();
        echo PHP_EOL;
        $this->renderer->render();
    }
}