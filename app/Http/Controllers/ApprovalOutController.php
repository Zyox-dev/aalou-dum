<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\ApprovalType;
use App\Models\Labour;
use App\LedgerEntryType;
use App\Models\Purchase;
use App\MaterialType;
use App\Models\ApprovalOut;
use Illuminate\Http\Request;
use App\Models\MaterialLedger;
use Illuminate\Validation\Rules\Enum;

class ApprovalOutController extends Controller
{
    public function index()
    {
        $approvals = ApprovalOut::latest()->get();

        $approvals = $approvals->map(function ($a) {
            $qty_type = $a->approval_type->value == 1 ? " Gram" : 'Carat';
            return [
                $a->serial_no,
                $a->approval_type_label,
                $a->labour->name,
                $a->labour->mobile,
                $a->rate,
                $a->qty . $qty_type,
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
            'labour_name' => 'required',
            'labour_mobile' => 'required'
            // 'gst_percent' => 'required|numeric',
        ]);
        // dd($request->all());
        $validated['labour_id'] = $this->resolveLabour($request);

        $purchasedQty = Purchase::where('purchase_type', $validated['approval_type'])
            ->sum($validated['approval_type'] === '1' ? 'weight_in_gram' : 'carat');

        $approvedQty = ApprovalOut::where('approval_type', $validated['approval_type'])
            ->sum('qty');

        $availableQty = $purchasedQty - $approvedQty;

        if ($validated['qty'] > $availableQty) {
            return redirect()->back()->withInput()->with('error', "Only {$availableQty} " . ($validated['approval_type'] === '1' ? 'grams' : 'karrots') . " available in stock.");
        }


        $approval = ApprovalOut::create($validated);
        $remark = 'Approval Out';
        switch ($approval->approval_type) {
            case 1:
                $remark = 'Approval Out - Gold';
                break;
            case 2:
                $remark = 'Approval Out - Diamond';
                break;
            case 3:
                $remark = 'Approval Out - Color Stone';
                break;
        }
        MaterialLedger::create([
            'date' => $approval->date,
            'material_type' => $approval->approval_type->value,
            'entry_type' => LedgerEntryType::ApprovalOut,
            'quantity' => $approval->qty,
            'labour_id' => $approval->labour_id,
            'reference_id' => $approval->id,
            'remarks' => $remark,
        ]);

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
            // 'gst_percent' => 'required|numeric',
        ]);
        $validated['labour_id'] = $this->resolveLabour($request);

        $purchasedQty = Purchase::where('purchase_type', $validated['approval_type'])
            ->sum($validated['approval_type'] === 'gold' ? 'weight_in_gram' : 'carat');

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

    private function resolveLabour(Request $request): string
    {
        $labourId = $request->input('labour_id');

        if ($labourId) {
            return $labourId;
        }

        $labour = Labour::firstOrCreate(
            ['name' => $request->labour_name],
            ['mobile' => $request->labour_mobile]
        );

        return $labour->id;
    }
}
