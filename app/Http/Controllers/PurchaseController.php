<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\PurchaseType as AppPurchaseType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;


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
                $p->karrot,
                $p->weight_in_gram ?? '-',
                $p->amount_total,
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
            'karrot' => 'required|numeric',
            'weight_in_gram' => 'nullable|numeric',
            'gst_percent' => 'nullable|numeric',
            'purchase_date' => 'required|date',
            'color_stone_name' => 'nullable|string|max:100',
        ]);

        // Auto calculate amount
        $validated['amount_total'] = $validated['purchase_type'] === '1'
            ? $validated['rate_per_unit'] * $validated['weight_in_gram']
            : $validated['rate_per_unit'] * $validated['karrot'];
        Purchase::create($validated);

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
            'karrot' => 'required|numeric',
            'weight_in_gram' => 'nullable|numeric',
            'gst_percent' => 'nullable|numeric',
            'purchase_date' => 'required|date',
            'color_stone_name' => 'nullable|string|max:100',
        ]);

        $validated['amount_total'] = $validated['purchase_type'] === '1'
            ? $validated['rate_per_unit'] * $validated['weight_in_gram']
            : $validated['rate_per_unit'] * $validated['karrot'];
        $purchase->update($validated);

        return redirect()->route('purchases.index')->with('success', 'Purchase updated!');
    }

    public function destroy(Purchase $purchase)
    {
        $purchase->delete();
        return redirect()->route('purchases.index')->with('success', 'Purchase deleted!');
    }
}
