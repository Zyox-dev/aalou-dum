<?php

namespace App\Http\Controllers;

use App\MaterialType;
use App\Models\Labour;
use App\Models\Product;
use App\LedgerEntryType;
use App\Models\CompanyData;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Models\MaterialLedger;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get();
        $products = $products->map(function ($p) {
            return [
                $p->product_no,
                $p->name,
                $p->gold_qty ?  $p->gold_qty . "g ( " . $p->gold_carat . " )" : "-",
                $p->diamond_qty ?? "-",
                $p->color_stone_qty ?? '-',
                number_format($p->total_amount, 2),
                number_format($p->gross_amount, 2),
                number_format($p->mrp, 2),
                $p->show_in_frontend ? 'Yes' : 'No',
                view('products.partials.action-buttons', ['id' => $p->id])->render(),
            ];
        });
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $carats = explode(',', CompanyData::first()?->carats ?? '');
        $adminPercent = CompanyData::first()?->admin_cost_percent ?? 0;
        $marginPercent = CompanyData::first()?->margin_percent ?? 0;
        $labours = Labour::orderBy('name')->get();


        return view('products.create', compact('carats', 'adminPercent', 'marginPercent', 'labours'));
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',

            'gold_qty' => 'required|numeric|min:0',
            'diamond_qty' => 'required|numeric|min:0',
            'color_stone_qty' => 'required|numeric|min:0',

            'labour_count' => 'required|integer|min:0',
            'labour_rate' => 'required|numeric|min:0',

            'description' => 'nullable|string|max:1000',
            'show_in_frontend' => 'nullable|boolean',
            'images.*' => 'nullable|image|max:5000',

            'gold_rate' => 'required_if:gold_qty,>0|nullable|numeric|min:0',

            'diamond_rate' => 'required_if:diamond_qty,>0|nullable|numeric|min:0',

            'color_stone_rate' => 'required_if:color_stone_qty,>0|nullable|numeric|min:0',
        ]);

        $validator->sometimes('gold_rate', 'required|numeric|gt:0', fn($input) => $input->gold_qty > 0);
        $validator->sometimes('gold_carat', 'required|string', fn($input) => $input->gold_qty > 0);
        $validator->sometimes('gold_labour_id', 'required|exists:labours,id', fn($input) => $input->gold_qty > 0);

        $validator->sometimes('diamond_rate', 'required|numeric|gt:0', fn($input) => $input->diamond_qty > 0);
        $validator->sometimes('diamond_labour_id', 'required|exists:labours,id', fn($input) => $input->diamond_qty > 0);

        $validator->sometimes('color_stone_rate', 'required|numeric|gt:0', fn($input) => $input->color_stone_qty > 0);
        $validator->sometimes('color_stone_labour_id', 'required|exists:labours,id', fn($input) => $input->color_stone_qty > 0);

        $validated = $validator->validate();


        $gold_total = $validated['gold_qty'] * $validated['gold_rate'];
        $diamond_total = $validated['diamond_qty'] * $validated['diamond_rate'];
        $color_stone_total = $validated['color_stone_qty'] * $validated['color_stone_rate'];
        $labour_total = $validated['labour_count'] * $validated['labour_rate'];

        // $gold_total = ($validated['gold_qty'] ?? 0) * ($validated['gold_rate'] ?? 0);
        // $diamond_total = ($validated['diamond_qty'] ?? 0) * ($validated['diamond_rate'] ?? 0);
        // $color_stone_total = ($validated['color_stone_qty'] ?? 0) * ($validated['color_stone_rate'] ?? 0);
        // $labour_total = ($validated['labour_count'] ?? 0) * ($validated['labour_rate'] ?? 0);


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

            'gold_labour_id' => $validated['gold_labour_id'] ?? null,
            'diamond_labour_id' => $validated['diamond_labour_id'] ?? null,
            'color_stone_labour_id' => $validated['color_stone_labour_id'] ?? null,
        ]);
        MaterialLedger::recordProductIn($product);

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
        $labours = Labour::orderBy('name')->get();

        return view('products.edit', compact('product', 'carats', 'adminPercent', 'marginPercent', 'labours'));
    }

    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',

            'gold_qty' => 'required|numeric|min:0',
            'diamond_qty' => 'required|numeric|min:0',
            'color_stone_qty' => 'required|numeric|min:0',

            'labour_count' => 'required|integer|min:0',
            'labour_rate' => 'required|numeric|min:0',

            'description' => 'nullable|string|max:1000',
            'show_in_frontend' => 'nullable|boolean',
            'images.*' => 'nullable|image|max:5000',

            'gold_rate' => 'required_if:gold_qty,>0|nullable|numeric|min:0',

            'diamond_rate' => 'required_if:diamond_qty,>0|nullable|numeric|min:0',

            'color_stone_rate' => 'required_if:color_stone_qty,>0|nullable|numeric|min:0',
        ]);

        $validator->sometimes('gold_rate', 'required|numeric|gt:0', fn($input) => $input->gold_qty > 0);
        $validator->sometimes('gold_carat', 'required|string', fn($input) => $input->gold_qty > 0);
        $validator->sometimes('gold_labour_id', 'required|exists:labours,id', fn($input) => $input->gold_qty > 0);

        $validator->sometimes('diamond_rate', 'required|numeric|gt:0', fn($input) => $input->diamond_qty > 0);
        $validator->sometimes('diamond_labour_id', 'required|exists:labours,id', fn($input) => $input->diamond_qty > 0);

        $validator->sometimes('color_stone_rate', 'required|numeric|gt:0', fn($input) => $input->color_stone_qty > 0);
        $validator->sometimes('color_stone_labour_id', 'required|exists:labours,id', fn($input) => $input->color_stone_qty > 0);

        $validated = $validator->validate();


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

            'gold_labour_id' => $validated['gold_labour_id'] ?? null,
            'diamond_labour_id' => $validated['diamond_labour_id'] ?? null,
            'color_stone_labour_id' => $validated['color_stone_labour_id'] ?? null,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('products', 'public');
                $product->images()->create(['image_path' => $path]);
            }
        }
        MaterialLedger::where('reference_id', $product->id)
            ->where('reference_type', 'App\Models\Product')
            ->delete();

        MaterialLedger::recordProductIn($product);
        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        $product->images()->delete();
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted!');
    }

    public function printTagsIndex()
    {
        $products = Product::with('images')->latest()->get();
        return view('products.print-tag-index', compact('products'));
    }

    public function printTagsStore(Request $request)
    {
        $ids = explode(',', $request->product_ids);
        $products = Product::whereIn('id', $ids)->get();
        return view('products.print-tags', compact('products'));
    }
}
