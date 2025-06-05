<?php

namespace App\Http\Controllers;

use App\Models\Labour;
use App\LedgerEntryType;
use App\MaterialType;
use Illuminate\Http\Request;
use App\Models\MaterialLedger;

class MaterialLedgerController extends Controller
{

    public function index(Request $request)
    {
        $material_type = $request->material_type;
        $labour_id = $request->labour_id;
        $from = $request->from_date;
        $to = $request->to_date;

        $ledgers = MaterialLedger::with('labour')
            ->when(
                $material_type !== null,
                fn($q) =>
                $q->where('material_type', $material_type)
            )
            ->when(
                $labour_id,
                fn($q) =>
                $q->where('labour_id', $labour_id)
            )
            ->when(
                $from && $to,
                fn($q) =>
                $q->whereBetween('date', [$from, $to])
            )
            ->orderBy('date', 'desc')
            ->get();

        $summary = [
            'total_purchase' => $ledgers->where('entry_type', LedgerEntryType::Purchase)->sum('quantity'),
            'total_out'      => $ledgers->where('entry_type', LedgerEntryType::ApprovalOut)->sum('quantity'),
            'total_in'       => $ledgers->where('entry_type', LedgerEntryType::ProductIn)->sum('quantity'),
        ];

        $summary['with_labour']  = $summary['total_out'] - $summary['total_in'];
        $summary['in_inventory'] = $summary['total_purchase'] - $summary['total_out'];

        return view('material-ledgers.index', [
            'ledgers' => $ledgers,
            'labours' => Labour::all(),
            'summary' => $summary,
            'materialTypes' => MaterialType::cases(),
            'request' => $request,
        ]);
    }
}
