<?php

namespace App\Http\Controllers;

use App\Models\CompanyData;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\InvoiceItem;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\MaterialLedger;
use Illuminate\Support\Facades\DB;
// use DB;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::latest()->get();
        $invoices = $invoices->map(function ($i) {
            return [
                $i->invoice_no,
                $i->customer_name,
                $i->purchase_date,
                number_format($i->total_amount, 2),
                view('invoices.partials.action-buttons', ['id' => $i->id])->render(),
            ];
        });
        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        $serials = Product::select('product_no', 'name', 'mrp')->get(); // for dropdown
        return view('invoices.create', compact('serials'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'purchase_date' => 'required|date',
            'customer_address' => 'nullable|string|max:500',
            'customer_gstin' => 'nullable|string|max:50',
            'customer_pan' => 'nullable|string|max:50',
            'cgst_percent' => 'nullable|numeric|min:0',
            'sgst_percent' => 'nullable|numeric|min:0',
            'igst_percent' => 'nullable|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.product_code' => 'required|string|exists:products,product_no',
            'items.*.product_name' => 'required|string',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.rate' => 'required|numeric|min:0',
            'items.*.total' => 'required|numeric|min:0',
        ], [
            'items.*.product_code.exists' => 'The selected product serial does not exist.',
            'items.*.quantity.min' => 'Quantity must be at least 0.01.',
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
            $companyName = CompanyData::first()->company_name;
            $invoice = Invoice::create([
                'customer_name' => $request->customer_name,
                'invoice_no' => Invoice::generateInvoiceNo($companyName),
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
                $invoiceItem = $invoice->items()->create($item);
                MaterialLedger::recordSale($invoiceItem);
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
        $storeData = CompanyData::first();
        // dd($invoice);
        return view('invoice', compact('invoice', 'storeData'));
    }

    public function destroy(Invoice $invoice)
    {
        MaterialLedger::where('reference_id', $invoice->id)
            ->where('reference_type', 'App\Models\Invoice')
            ->delete();

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
