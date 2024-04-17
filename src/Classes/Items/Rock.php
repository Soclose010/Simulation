<?php

namespace App\Classes\Items;

use App\Classes\Core\Coordinate;
use App\Classes\LifeForms\Entity;

class Rock extends Entity
{
    public function __construct(Coordinate $coordinate)
    {
        parent::__construct($coordinate);
        $this->visual = "🗿";
        $this->name = "камень";
    }
}