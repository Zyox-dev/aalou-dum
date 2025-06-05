<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\LedgerEntryType;
use App\MaterialType;
use App\Models\CompanyData;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Models\MaterialLedger;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('images')->latest()->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $carats = explode(',', CompanyData::first()?->carats ?? '');
        $adminPercent = CompanyData::first()?->admin_cost_percent ?? 0;
        $marginPercent = CompanyData::first()?->margin_percent ?? 0;

        return view('products.create', compact('carats', 'adminPercent', 'marginPercent'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'gold_qty' => 'required|numeric|min:0',
            'gold_rate' => 'required|numeric|min:0',
            'gold_carat' => 'required|string',

            'diamond_qty' => 'required|numeric|min:0',
            'diamond_rate' => 'required|numeric|min:0',

            'color_stone_qty' => 'required|numeric|min:0',
            'color_stone_rate' => 'required|numeric|min:0',

            'labour_count' => 'required|integer|min:0',
            'labour_rate' => 'required|numeric|min:0',

            'description' => 'nullable|string|max:1000',
            'show_in_frontend' => 'nullable|boolean',

            'images.*' => 'nullable|image|max:5000',
        ]);

        $gold_total = $validated['gold_qty'] * $validated['gold_rate'];
        $diamond_total = $validated['diamond_qty'] * $validated['diamond_rate'];
        $color_stone_total = $validated['color_stone_qty'] * $validated['color_stone_rate'];
        $labour_total = $validated['labour_count'] * $validated['labour_rate'];

        $total = $gold_total + $diamond_total + $color_stone_total + $labour_total;

        $company = CompanyData::first();
        $adminPercent = $company->admin_cost_percent ?? 0;
        $marginPercent = $company->margin_percent ?? 0;

        $gross = $total + ($total * $adminPercent / 100);
        $mrp = $gross + ($gross * $marginPercent / 100);

        $product = Product::create([
            'name' => $validated['name'],

            'gold_qty' => $validated['gold_qty'],
            'gold_rate' => $validated['gold_rate'],
            'gold_total' => $gold_total,
            'gold_carat' => $validated['gold_carat'],

            'diamond_qty' => $validated['diamond_qty'],
            'diamond_rate' => $validated['diamond_rate'],
            'diamond_total' => $diamond_total,

            'color_stone_qty' => $validated['color_stone_qty'],
            'color_stone_rate' => $validated['color_stone_rate'],
            'color_stone_total' => $color_stone_total,

            'labour_count' => $validated['labour_count'],
            'labour_rate' => $validated['labour_rate'],
            'labour_total' => $labour_total,

            'total_amount' => $total,
            'gross_amount' => $gross,
            'mrp' => $mrp,
            'description' => $validated['description'] ?? null,
            'show_in_frontend' => $request->has('show_in_frontend'),
        ]);


        if ($product->gold_qty) {
            MaterialLedger::create([
                'date' => $product->created_at->toDateString(), // or use a product date field
                'material_type' => MaterialType::Gold,
                'entry_type' => LedgerEntryType::ProductIn,
                'quantity' => $product->gold_qty,
                'labour_id' => null, // Product me labour nahi linked
                'reference_id' => $product->id,
                'remarks' => 'Product In - Gold',
            ]);
        }

        if ($product->diamond_qty) {
            MaterialLedger::create([
                'date' => $product->created_at->toDateString(),
                'material_type' => MaterialType::Diamond,
                'entry_type' => LedgerEntryType::ProductIn,
                'quantity' => $product->diamond_qty,
                'labour_id' => null,
                'reference_id' => $product->id,
                'remarks' => 'Product In - Diamond',
            ]);
        }

        if ($product->color_stone_qty) {
            MaterialLedger::create([
                'date' => $product->created_at->toDateString(),
                'material_type' => MaterialType::ColorStone,
                'entry_type' => LedgerEntryType::ProductIn,
                'quantity' => $product->color_stone_qty,
                'labour_id' => null,
                'reference_id' => $product->id,
                'remarks' => 'Product In - Color Stone',
            ]);
        }


        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('products', 'public');
                $product->images()->create(['image_path' => $path]);
            }
        }

        return redirect()->route('products.index')->with('success', 'Product created successfully!');
    }

    public function edit(Product $product)
    {
        $product->load('images');
        $carats = explode(',', CompanyData::first()?->carats ?? '');
        $adminPercent = CompanyData::first()?->admin_cost_percent ?? 0;
        $marginPercent = CompanyData::first()?->margin_percent ?? 0;

        return view('products.edit', compact('product', 'carats', 'adminPercent', 'marginPercent'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'gold_qty' => 'required|numeric|min:0',
            'gold_rate' => 'required|numeric|min:0',
            'gold_carat' => 'required|string',

            'diamond_qty' => 'required|numeric|min:0',
            'diamond_rate' => 'required|numeric|min:0',

            'color_stone_qty' => 'required|numeric|min:0',
            'color_stone_rate' => 'required|numeric|min:0',

            'labour_count' => 'required|integer|min:0',
            'labour_rate' => 'required|numeric|min:0',

            'description' => 'nullable|string|max:1000',
            'show_in_frontend' => 'nullable|boolean',

            'images.*' => 'nullable|image|max:5000',
        ]);

        $gold_total = $validated['gold_qty'] * $validated['gold_rate'];
        $diamond_total = $validated['diamond_qty'] * $validated['diamond_rate'];
        $color_stone_total = $validated['color_stone_qty'] * $validated['color_stone_rate'];
        $labour_total = $validated['labour_count'] * $validated['labour_rate'];

        $total = $gold_total + $diamond_total + $color_stone_total + $labour_total;

        $company = CompanyData::first();
        $adminPercent = $company->admin_cost_percent ?? 0;
        $marginPercent = $company->margin_percent ?? 0;

        $gross = $total + ($total * $adminPercent / 100);
        $mrp = $gross + ($gross * $marginPercent / 100);

        $product->update([
            'name' => $validated['name'],
            'gold_qty' => $validated['gold_qty'],
            'gold_rate' => $validated['gold_rate'],
            'gold_total' => $gold_total,
            'gold_carat' => $validated['gold_carat'],

            'diamond_qty' => $validated['diamond_qty'],
            'diamond_rate' => $validated['diamond_rate'],
            'diamond_total' => $diamond_total,

            'color_stone_qty' => $validated['color_stone_qty'],
            'color_stone_rate' => $validated['color_stone_rate'],
            'color_stone_total' => $color_stone_total,

            'labour_count' => $validated['labour_count'],
            'labour_rate' => $validated['labour_rate'],
            'labour_total' => $labour_total,

            'total_amount' => $total,
            'gross_amount' => $gross,
            'mrp' => $mrp,
            'description' => $validated['description'] ?? null,
            'show_in_frontend' => $request->has('show_in_frontend'),
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('products', 'public');
                $product->images()->create(['image_path' => $path]);
            }
        }

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        $product->images()->delete();
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted!');
    }
}
