<?php

namespace App\Classes\Core;

use App\Classes\Core\Actions\ActionInterface;
use App\Classes\Core\Map\MapInterface;
use App\Classes\Core\Render\RenderInterface;

class Simulation
{
    private MapInterface $map;
    private int $turnCounter;
    private RenderInterface $renderer;

    private ActionInterface $initAction;
    private ActionInterface $turnAction;

    public function __construct(MapInterface $map, RenderInterface $renderer, ActionInterface $initAction, ActionInterface $turnAction)
    {
        $this->map = $map;
        $this->renderer = $renderer;
        $this->turnCounter = 0;
        $this->initAction = $initAction;
        $this->turnAction = $turnAction;
    }

    public function initAction(): void
    {
        $this->initAction->make();
        echo "Инициализация поля" . PHP_EOL;
        $this->renderer->render();
    }

    public function turnAction(): void
    {
        $this->turnCounter++;
        echo "Ход - {$this->turnCounter}" . PHP_EOL;
        $this->turnAction->make();
    }

    public function endless(): void
    {
        while ($this->map->haveAliveCreatures()) {
            $this->turnAction();
        }
    }
}