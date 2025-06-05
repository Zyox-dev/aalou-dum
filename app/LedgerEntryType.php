<?php

namespace App;

enum LedgerEntryType: int
{
    case Purchase = 0;
    case ApprovalOut = 1;
    case ProductIn = 2;

    public function label(): string
    {
        return match ($this) {
            self::Purchase => 'Purchase',
            self::ApprovalOut => 'Approval Out',
            self::ProductIn => 'Product In',
        };
    }
}
