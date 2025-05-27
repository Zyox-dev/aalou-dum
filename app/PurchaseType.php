<?php

namespace App;

enum PurchaseType: int
{
    case Gold = 1;
    case Diamond = 2;
    case ColorStone = 3;

    public function label(): string
    {
        return match ($this) {
            self::Gold => 'Gold',
            self::Diamond => 'Diamond',
            self::ColorStone => 'Color Stone',
        };
    }
}
