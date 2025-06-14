<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MaterialLedger;
use App\Models\Labour;
use App\MaterialType;
use Carbon\Carbon;

class MaterialLedgerController extends Controller
{

    public function index(Request $request)
    {
        $query = MaterialLedger::query()
            ->with(['labour', 'reference'])
            ->orderBy('date')
            ->orderBy('created_at');

        // ✅ Filters
        $date = Carbon::today()->subDay();
        if ($request->filled('material_type')) {
            $query->where('material_type', $request->material_type);
        }

        if ($request->filled('labour_id')) {
            $query->where('labour_id', $request->labour_id);
        }

        if ($request->filled('from_date')) {
            $query->where('date', '>=', $request->from_date);
        } else {
            $query->where('date', '>=', $date);
        }

        if ($request->filled('to_date')) {
            $query->where('date', '<=', $request->to_date);
        } else {
            $query->where('date', '<=', $date);
        }

        $ledgers = $query->get();

        // ✅ Summary values
        $summary = [
            'total_purchase' => $ledgers->where('entry_type', \App\LedgerEntryType::PURCHASE)->sum('quantity'),
            'total_out' => $ledgers->where('entry_type', \App\LedgerEntryType::APPROVAL_OUT)->sum('quantity'),
            'total_in' => $ledgers->where('entry_type', \App\LedgerEntryType::APPROVAL_IN)->sum('quantity'),
            'with_labour' => $ledgers->where('entry_type', \App\LedgerEntryType::APPROVAL_OUT)->sum('quantity') -
                $ledgers->where('entry_type', \App\LedgerEntryType::APPROVAL_IN)->sum('quantity'),
            'in_inventory' => $ledgers->where('entry_type', \App\LedgerEntryType::PURCHASE)->sum('quantity') -
                $ledgers->where('entry_type', \App\LedgerEntryType::APPROVAL_OUT)->sum('quantity'),
        ];

        $materialTypes = MaterialType::cases();
        $labours = Labour::orderBy('name')->get();

        return view('material-ledgers.index', compact('ledgers', 'labours', 'materialTypes', 'summary', 'request'));
    }
}
