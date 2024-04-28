<?php

namespace App\Classes\Core\Printer;

use App\Classes\Core\Coordinate;

interface PrinterInterface
{
    public function activeEntityInfo(string $activeEntity, int $activeEntityHp, bool $activeEntityHunger, Coordinate $coordinateActiveEntity): void;

    public function move(string $targetEntity, int $remainingSteps, Coordinate $coordinateTargetEntity, array $steps): void;

    public function attack(int $remainingSteps, int $targetHp): void;

    public function eat(int $remainingSteps, int $targetWeight): void;

    public function decay(string $name, Coordinate $coordinate, int $weight, int $decay): void;

    public function noTarget(string $name, Coordinate $coordinate, int $hp): void;
}