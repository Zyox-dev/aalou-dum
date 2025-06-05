<?php

namespace App\Http\Controllers;

use App\LedgerEntryType;
use App\Models\Purchase;
use App\MaterialType;
use Illuminate\Http\Request;
use App\Models\MaterialLedger;
use Illuminate\Validation\Rules\Enum;
use App\PurchaseType as AppPurchaseType;


class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::latest()->get();
        $purchases = $purchases->map(function ($p) {
            return [
                $p->purchase_type_label,
                $p->color_stone_name ?? '-',
                $p->rate_per_unit,
                $p->carat,
                $p->weight_in_gram ?? '-',
                $p->amount_total,
                $p->cgst,
                $p->sgst,
                $p->igst,
                $p->gross_amount,
                $p->purchase_date->format('d-m-Y'),
                view('purchases.partials.action-buttons', ['id' => $p->id])->render(),
            ];
        });
        return view('purchases.index', compact('purchases'));
    }

    public function create()
    {
        $types = collect(AppPurchaseType::cases())->map(fn($level) => [
            'value' => $level->value,
            'label' => $level->label(),
        ]);
        return view('purchases.create', compact('types'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'purchase_type' => ['required', new Enum(AppPurchaseType::class)],
            'rate_per_unit' => 'required|numeric',
            'carat' => 'required|numeric',
            'weight_in_gram' => 'nullable|numeric',
            'purchase_date' => 'required|date',
            'color_stone_name' => 'nullable|string|max:100',
            'cgst' => 'nullable|numeric|min:0',
            'sgst' => 'nullable|numeric|min:0',
            'igst' => 'nullable|numeric|min:0',
        ]);

        // Set defaults if null
        $validated['cgst'] = $validated['cgst'] ?? 0;
        $validated['sgst'] = $validated['sgst'] ?? 0;
        $validated['igst'] = $validated['igst'] ?? 0;

        // Calculate total amount
        $validated['amount_total'] = $validated['purchase_type'] === '1'
            ? $validated['rate_per_unit'] * $validated['weight_in_gram']
            : $validated['rate_per_unit'] * $validated['carat'];

        $totalGstPercent = $validated['cgst'] + $validated['sgst'] + $validated['igst'];
        $validated['gross_amount'] = $validated['amount_total'] + ($validated['amount_total'] * $totalGstPercent / 100);

        $purchase = Purchase::create($validated);
        // dd($purchase->purchase_type->value);
        MaterialLedger::create([
            'date' => $purchase->purchase_date,
            'material_type' => $purchase->purchase_type->value,
            'entry_type' => LedgerEntryType::Purchase,
            'quantity' => $validated['purchase_type'] === '1' ? $validated['weight_in_gram'] : $validated['carat'],
            'labour_id' => null, // no labour in purchase
            'reference_id' => $purchase->id,
            'remarks' => 'Purchase entry',
        ]);

        return redirect()->route('purchases.index')->with('success', 'Purchase added!');
    }

    public function edit(Purchase $purchase)
    {
        $types = collect(AppPurchaseType::cases())->map(fn($level) => [
            'value' => $level->value,
            'label' => $level->label(),
        ]);

        return view('purchases.edit', compact('purchase', 'types'));
    }

    public function update(Request $request, Purchase $purchase)
    {
        $validated = $request->validate([
            'purchase_type' => ['required', new Enum(AppPurchaseType::class)],
            'rate_per_unit' => 'required|numeric',
            'carat' => 'required|numeric',
            'weight_in_gram' => 'nullable|numeric',
            'purchase_date' => 'required|date',
            'color_stone_name' => 'nullable|string|max:100',
            'cgst' => 'nullable|numeric|min:0',
            'sgst' => 'nullable|numeric|min:0',
            'igst' => 'nullable|numeric|min:0',
        ]);

        // Set defaults if null
        $validated['cgst'] = $validated['cgst'] ?? 0;
        $validated['sgst'] = $validated['sgst'] ?? 0;
        $validated['igst'] = $validated['igst'] ?? 0;

        // Calculate total amount
        $validated['amount_total'] = $validated['purchase_type'] === '1'
            ? $validated['rate_per_unit'] * $validated['weight_in_gram']
            : $validated['rate_per_unit'] * $validated['carat'];

        // Calculate gross amount
        $totalGstPercent = $validated['cgst'] + $validated['sgst'] + $validated['igst'];
        $validated['gross_amount'] = $validated['amount_total'] + ($validated['amount_total'] * $totalGstPercent / 100);

        $purchase->update($validated);
        return redirect()->route('purchases.index')->with('success', 'Purchase updated!');
    }

    public function destroy(Purchase $purchase)
    {
        $purchase->delete();
        return redirect()->route('purchases.index')->with('success', 'Purchase deleted!');
    }
}
