<?php

namespace App\Http\Controllers;

use App\PurchaseType;
use App\Models\Purchase;
use App\Models\ApprovalOut;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        $types = collect(PurchaseType::cases())->map(fn($level) => [
            'value' => $level->value,
            'label' => $level->label(),
        ]);

        $stockData = [];

        foreach ($types as $type) {
            $field = $type['value'] === 1 ? 'weight_in_gram' : 'karrot';

            $purchasedQty = Purchase::where('purchase_type', $type['value'])
                ->sum($field);

            $approvedQty = ApprovalOut::where('approval_type', $type['value'])
                ->sum('qty');

            $available = $purchasedQty - $approvedQty;

            $stockData[] = [
                $type['label'],                         // Type
                number_format($purchasedQty, 2),        // Purchased
                number_format($approvedQty, 2),         // Approved
                number_format($available, 2),           // Available
                $type['value'] === 1 ? 'Gram' : 'Karrot', // Unit
            ];
        }

        return view('stock.index', compact('stockData'));
    }
}
