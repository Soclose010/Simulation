<?php

namespace App\Classes\Core;

use App\Classes\Core\Actions\InitAction;
use App\Classes\Core\Actions\TurnAction;
use App\Classes\Core\Map\MapInterface;
use App\Classes\Core\Render\RenderInterface;

class Simulation
{
    private MapInterface $map;
    private int $turnCounter;
    private RenderInterface $renderer;

    public function __construct(MapInterface $map, RenderInterface $renderer)
    {
        $this->map = $map;
        $this->renderer = $renderer;
        $this->turnCounter = 0;
    }

    public function initAction(): void
    {
        $action = new InitAction($this->map);
        $action->make();
        echo "Инициализация поля" . PHP_EOL;
        $this->renderer->render();
    }

    public function turnAction(TurnAction $action): void
    {
        $this->turnCounter++;
        echo "Ход - {$this->turnCounter}" . PHP_EOL;
        $action->make();
    }

    public function endless(): void
    {
        $action = new turnAction($this->map, $this->renderer);
        while ($this->map->haveAliveCreatures()) {
            $this->turnAction($action);
        }
    }
}