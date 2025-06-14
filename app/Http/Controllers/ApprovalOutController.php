<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\ApprovalType;
use App\MaterialType;
use App\Models\Labour;
use App\LedgerEntryType;
use App\Models\Purchase;
use App\Models\ApprovalOut;
use Illuminate\Http\Request;
use App\Models\MaterialLedger;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make($request->all(), [
            'approval_type' => ['required', new Enum(ApprovalType::class)],
            'date' => 'required|date',
            'rate' => 'required|numeric',
            'qty' => 'required|numeric',
            'labour_name' => ['required', 'string', 'max:100'],
            'labour_mobile' => [
                'required',
                'digits:10',
                function ($attribute, $value, $fail) use ($request) {
                    $existing = Labour::where('name', $request->labour_name)->first();

                    if (! $existing) {
                        // If name is new → mobile must not exist
                        if (Labour::where('mobile', $value)->exists()) {
                            $fail('This mobile already belongs to another labour.');
                        }
                    } else {
                        // If name exists → mobile must match that labour
                        if ($existing->mobile !== $value) {
                            $fail('This mobile does not match the existing labour record.');
                        }
                    }
                }
            ],
        ]);
        $validated = $validator->validate();
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
        MaterialLedger::recordApprovalOut($approval);

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
        $validator = Validator::make($request->all(), [
            'approval_type' => ['required', new Enum(ApprovalType::class)],
            'date' => 'required|date',
            'rate' => 'required|numeric',
            'qty' => 'required|numeric',
            'labour_name' => ['required', 'string', 'max:100'],
            'labour_mobile' => [
                'required',
                'digits:10',
                function ($attribute, $value, $fail) use ($request) {
                    $existing = Labour::where('name', $request->labour_name)->first();

                    if (! $existing) {
                        // If name is new → mobile must not exist
                        if (Labour::where('mobile', $value)->exists()) {
                            $fail('This mobile already belongs to another labour.');
                        }
                    } else {
                        // If name exists → mobile must match that labour
                        if ($existing->mobile !== $value) {
                            $fail('This mobile does not match the existing labour record.');
                        }
                    }
                }
            ],
        ]);
        $validated = $validator->validate();
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
        MaterialLedger::where('reference_id', $approval_out->id)
            ->where('reference_type', 'App\Models\ApprovalOut')
            ->delete();

        MaterialLedger::recordApprovalOut($approval_out);
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
