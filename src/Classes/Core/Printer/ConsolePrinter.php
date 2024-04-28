<?php

namespace App\Classes\Core\Printer;

use App\Classes\Core\Coordinate;

class ConsolePrinter implements PrinterInterface
{
    private const ENTITY_INFO = [
        "Информация об объекте",
        "Имя",
        "Здоровье",
        "Статус голода",
        "Координаты",
    ];
    private const MOVE = [
        "Движение",
        "Цель",
        "Осталось действий",
        "Координаты цели",
        "Путь до цели",
    ];
    private const ATTACK = [
        "Атака",
        "Осталось действий",
        "Хп цели",
    ];
    private const EAT = [
        "Поедание",
        "Осталось действий",
        "Вес цели",
    ];

    private const DECAY = [
        "Гниение",
        "Объект",
        "Координаты",
        "Вес",
        "Порча",
    ];

    private const NO_TARGET = [
        "Целей нет",
        "Объект",
        "Координаты",
        "Здоровье",
    ];

    public function activeEntityInfo(string $activeEntity, int $activeEntityHp, bool $activeEntityHunger, Coordinate $coordinateActiveEntity): void
    {
        $info = [
            $activeEntity,
            $activeEntityHp,
            $activeEntityHunger ? "Есть" : "Нет",
            $coordinateActiveEntity->getStringCords(),
        ];
        $this->printInfo($this::ENTITY_INFO, $info);
    }

    public function move(string $targetEntity, int $remainingSteps, Coordinate $coordinateTargetEntity, array $steps): void
    {
        $stringSteps = "";
        $stepsCount = count($steps);
        if ($stepsCount == 0) {
            echo "===== " . $this::MOVE[0] . " =====" . PHP_EOL;
            echo "Движение не требуется" . PHP_EOL . PHP_EOL;
            return;
        }
        /** @var Coordinate[] $steps */
        for ($i = 0; $i < $stepsCount; $i++) {
            if ($i != $stepsCount - 1) {
                $stringSteps .= $steps[$i]->getStringCords() . " => ";
            } else {
                $stringSteps .= $steps[$i]->getStringCords();
            }
        }
        $info = [
            $targetEntity,
            $remainingSteps,
            $coordinateTargetEntity->getStringCords(),
            $stringSteps,
        ];
        $this->printInfo($this::MOVE, $info);
    }

    public function attack(int $remainingSteps, int $targetHp): void
    {
        $info = [
            $remainingSteps,
            $targetHp,
        ];
        $this->printInfo($this::ATTACK, $info);
    }

    public function eat(int $remainingSteps, int $targetWeight): void
    {
        $info = [
            $remainingSteps,
            $targetWeight,
        ];
        $this->printInfo($this::EAT, $info);
    }

    private function printInfo(array $header, array $info): void
    {
        echo "===== " . $header[0] . " =====" . PHP_EOL;
        $fillerCount = 20;
        foreach ($info as $key => $item) {
            $fillerCount -= mb_strlen($header[$key + 1], "UTF-8");
            echo $header[$key + 1] . str_repeat(" ", $fillerCount) . $item . PHP_EOL;
            $fillerCount = 20;
        }
        echo PHP_EOL;
    }

    public function decay(string $name, Coordinate $coordinate, int $weight, int $decay): void
    {
        $info = [
            $name,
            $coordinate->getStringCords(),
            $weight,
            $decay,
        ];
        $this->printInfo($this::DECAY, $info);
    }

    public function noTarget(string $name, Coordinate $coordinate, int $hp): void
    {
        $info = [
            $name,
            $coordinate->getStringCords(),
            $hp,
        ];
        $this->printInfo($this::NO_TARGET, $info);
    }
}