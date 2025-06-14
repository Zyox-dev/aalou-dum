<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanyData;

class CompanyDataController extends Controller
{
    public function edit()
    {
        $data = CompanyData::first(); // only 1 record
        return view('company-data.edit', compact('data'));
    }

    public function update(Request $request)
    {
        $data = CompanyData::first();

        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'address' => 'required|string',
            'gstin' => 'nullable|string|max:15',
            'pan_no' => 'nullable|string|max:15',
            'state_code' => 'nullable|string|max:15',
            'district_code' => 'nullable|string|max:15',
            'city_location' => 'nullable|string|max:15',
            'bank_name' => 'nullable|string|max:100',
            'bank_ifsc_code' => 'nullable|string|max:15',
            'bank_account_no' => 'nullable|string|max:20',
            'admin_cost_percent' => 'required|numeric|min:0',
            'margin_percent' => 'required|numeric|min:0',
            'carats' => 'nullable|string|max:255',
            'logo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $data->update($validated);

        return redirect()->back()->with('success', 'Company data updated.');
    }
}
