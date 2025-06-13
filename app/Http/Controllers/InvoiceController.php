<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Product;
use App\Models\InvoiceItem;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use DB;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::latest()->get();
        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        return view('invoices.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:100',
            'purchase_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_code' => 'required|string|size:6',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'cgst_percent' => 'required|numeric|min:0',
            'sgst_percent' => 'required|numeric|min:0',
            'igst_percent' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $items = [];
            $subtotal = 0;

            foreach ($request->items as $item) {
                $product = Product::where('product_no', $item['product_code'])->firstOrFail();
                $qty = $item['quantity'];
                $rate = $product->mrp;
                $total = $rate * $qty;

                $items[] = [
                    'product_id' => $product->id,
                    'product_code' => $product->product_no,
                    'product_name' => $product->name,
                    'quantity' => $qty,
                    'rate' => $rate,
                    'total' => $total,
                ];

                $subtotal += $total;
            }

            $gstPercent = $request->cgst_percent + $request->sgst_percent + $request->igst_percent;
            $gstAmount = ($subtotal * $gstPercent) / 100;
            $totalAmount = $subtotal + $gstAmount;

            $invoice = Invoice::create([
                'customer_name' => $request->customer_name,
                'customer_address' => $request->customer_address,
                'customer_gstin' => $request->customer_gstin,
                'customer_pan' => $request->customer_pan,
                'purchase_date' => $request->purchase_date,
                'cgst_percent' => $request->cgst_percent,
                'sgst_percent' => $request->sgst_percent,
                'igst_percent' => $request->igst_percent,
                'subtotal_amount' => $subtotal,
                'gst_amount' => $gstAmount,
                'total_amount' => $totalAmount,
            ]);

            foreach ($items as $item) {
                $invoice->items()->create($item);
            }

            DB::commit();
            return redirect()->route('invoices.index');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function print(Invoice $invoice)
    {
        $invoice->load('items.product');
        // dd($invoice);
        return view('invoice', compact('invoice'));
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully.');
    }
    public function getProductDetail($code)
    {
        $product = Product::where('product_no', $code)->first();

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        return response()->json([
            'id' => $product->id,
            'name' => $product->name,
            'product_code' => $product->product_no,
            'mrp' => $product->mrp,
        ]);
    }
}
