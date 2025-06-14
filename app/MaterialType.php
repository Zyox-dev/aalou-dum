<?php

namespace App;

enum MaterialType: int
{
    case GOLD = 1;
    case DIAMOND = 2;
    case COLOR_STONE = 3;
    case PRODUCT = 4;

    public function label(): string
    {
        return match ($this) {
            self::GOLD => 'Gold',
            self::DIAMOND => 'Diamond',
            self::COLOR_STONE => 'Color Stone',
            self::PRODUCT => 'Product',
        };
    }
    public function unit(): string
    {
        return match ($this) {
            self::GOLD => 'Gram',
            self::DIAMOND, self::COLOR_STONE => 'Carat',
            self::PRODUCT => 'Pcs',
        };
    }
}
