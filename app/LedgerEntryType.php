<?php

namespace App;

enum LedgerEntryType: int
{
    case PURCHASE = 1;
    case APPROVAL_OUT = 2;
    case APPROVAL_IN = 3;
    case SALE = 4;

    public function label(): string
    {
        return match ($this) {
            self::PURCHASE => 'Purchase',
            self::APPROVAL_OUT => 'Approval Out',
            self::APPROVAL_IN => 'Approval In',
            self::SALE => 'Sale',
        };
    }
}
