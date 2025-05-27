<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\ApprovalType;
use App\Models\Purchase;
use App\Models\ApprovalOut;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class ApprovalOutController extends Controller
{
    public function index()
    {
        $approvals = ApprovalOut::latest()->get();

        $approvals = $approvals->map(function ($a) {
            $qty_type = $a->approval_type->value == 1 ? " Gram" : ' Karrot';
            return [
                $a->serial_no,
                $a->approval_type_label,
                $a->rate,
                $a->qty . $qty_type,
                $a->gst_percent,
                $a->date->format('d-m-Y'),
                view('approval_out.partials.action-buttons', ['id' => $a->id])->render(),
            ];
        });
        return view('approval_out.index', compact('approvals'));
    }

    public function create()
    {
        $types = collect(ApprovalType::cases())->map(fn($level) => [
            'value' => $level->value,
            'label' => $level->label(),
        ]);
        return view('approval_out.create', compact('types'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'approval_type' => ['required', new Enum(ApprovalType::class)],
            'date' => 'required|date',
            'rate' => 'required|numeric',
            'qty' => 'required|numeric',
            'gst_percent' => 'required|numeric',
        ]);

        $purchasedQty = Purchase::where('purchase_type', $validated['approval_type'])
            ->sum($validated['approval_type'] === '1' ? 'weight_in_gram' : 'karrot');

        $approvedQty = ApprovalOut::where('approval_type', $validated['approval_type'])
            ->sum('qty');

        $availableQty = $purchasedQty - $approvedQty;

        if ($validated['qty'] > $availableQty) {
            return redirect()->back()->withInput()->with('error', "Only {$availableQty} " . ($validated['approval_type'] === '1' ? 'grams' : 'karrots') . " available in stock.");
        }


        ApprovalOut::create($validated);

        return redirect()->route('approval-outs.index')->with('success', 'Approval Out created successfully.');
    }

    public function edit(ApprovalOut $approval_out)
    {
        $types = collect(ApprovalType::cases())->map(fn($level) => [
            'value' => $level->value,
            'label' => $level->label(),
        ]);
        return view('approval_out.edit', compact('approval_out', 'types'));
    }

    public function update(Request $request, ApprovalOut $approval_out)
    {
        $validated = $request->validate([
            'approval_type' => ['required', new Enum(ApprovalType::class)],
            'date' => 'required|date',
            'rate' => 'required|numeric',
            'qty' => 'required|numeric',
            'gst_percent' => 'required|numeric',
        ]);

        $purchasedQty = Purchase::where('purchase_type', $validated['approval_type'])
            ->sum($validated['approval_type'] === 'gold' ? 'weight_in_gram' : 'karrot');

        $approvedQty = ApprovalOut::where('approval_type', $validated['approval_type'])
            ->where('id', '!=', $approval_out->id)
            ->sum('qty');

        $availableQty = $purchasedQty - $approvedQty;

        if ($validated['qty'] > $availableQty) {
            return redirect()->back()->withInput()->with('error', "Only {$availableQty} " . ($validated['approval_type'] === '1' ? 'grams' : 'karrots') . " available in stock.");
        }


        $approval_out->update($validated);

        return redirect()->route('approval-outs.index')->with('success', 'Approval Out updated successfully.');
    }

    public function destroy(ApprovalOut $approval_out)
    {
        $approval_out->delete();

        return redirect()->route('approval-outs.index')->with('success', 'Approval Out deleted.');
    }
}
