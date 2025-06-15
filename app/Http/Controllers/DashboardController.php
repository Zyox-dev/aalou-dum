<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\ApprovalOut;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $monthlyData = Purchase::selectRaw("purchase_type, MONTH(purchase_date) as month, SUM(amount_total) as total")
            ->groupBy('purchase_type', 'month')
            ->get()
            ->groupBy('purchase_type');

        $chartData = [
            'gold' => array_fill(1, 12, 0),
            'diamond' => array_fill(1, 12, 0),
            'color_stone' => array_fill(1, 12, 0),
        ];
        $totalPurchase = 0;
        foreach ($monthlyData as $type => $rows) {

            foreach ($rows as $row) {
                $type = match ($type) {
                    1 => 'gold',
                    2 => 'diamond',
                    3 => 'color_stone',
                };
                $totalPurchase += (float)$row->total;
                $chartData[$type][(int)$row->month] = (float)$row->total;
            }
        }

        $approvalData = ApprovalOut::selectRaw('approval_type, SUM(qty) as total')
            ->groupBy('approval_type')
            ->pluck('total', 'approval_type');

        $approvalChart = [
            'labels' => ['Gold', 'Diamond', 'Color Stone'],
            'series' => [
                $approvalData['gold'] ?? 0,
                $approvalData['diamond'] ?? 0,
                $approvalData['color_stone'] ?? 0,
            ]
        ];

        // dd($chartData);
        return view('dashboard', [
            'purchaseChart' => [
                'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                'series' => [
                    ['name' => 'Gold', 'data' => array_values($chartData['gold'])],
                    ['name' => 'Diamond', 'data' => array_values($chartData['diamond'])],
                    ['name' => 'Color Stone', 'data' => array_values($chartData['color_stone'])],
                ]
            ],
            'approvalChart' => $approvalChart,
            'totalPurchase' => $totalPurchase
        ]);
    }
}
