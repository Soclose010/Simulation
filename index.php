<?php

require_once "vendor/autoload.php";

use App\Classes\Core\Actions\InitAction;
use App\Classes\Core\Actions\TurnAction;
use App\Classes\Core\Coordinate;
use App\Classes\Core\Map\Map;
use App\Classes\Core\Printer\ConsolePrinter;
use App\Classes\Core\Render\Renderer;
use App\Classes\Core\Simulation;

$start = new Coordinate(0,0);
$end = new Coordinate(8,9);
$map = new Map($start, $end);
$renderer = new Renderer($map);
$printer = new ConsolePrinter();
$initAction = new InitAction($map, $printer);
$turnAction = new TurnAction($map, $renderer, $printer);
$simulation = new Simulation($map, $renderer, $initAction, $turnAction);
$simulation->initAction();
$simulation->endless();
