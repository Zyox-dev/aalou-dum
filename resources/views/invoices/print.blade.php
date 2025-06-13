<x-layout.default>
    <div class="p-8 bg-white max-w-3xl mx-auto" id="invoice">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold">Sales Invoice</h1>
            <p class="text-sm text-gray-600">Invoice Date: {{ $invoice->purchase_date }}</p>
        </div>

        <div class="mb-4">
            <h2 class="font-semibold text-lg mb-1">Customer Details</h2>
            <p><strong>Name:</strong> {{ $invoice->customer_name }}</p>
            <p><strong>Address:</strong> {{ $invoice->customer_address ?? '-' }}</p>
            <p><strong>GSTIN:</strong> {{ $invoice->customer_gstin ?? '-' }}</p>
            <p><strong>PAN:</strong> {{ $invoice->customer_pan ?? '-' }}</p>
        </div>

        <table class="w-full border border-collapse text-sm mb-4">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border px-2 py-1">#</th>
                    <th class="border px-2 py-1">Product Code</th>
                    <th class="border px-2 py-1">Product Name</th>
                    <th class="border px-2 py-1">Qty</th>
                    <th class="border px-2 py-1">Rate</th>
                    <th class="border px-2 py-1">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoice->items as $index => $item)
                    <tr>
                        <td class="border px-2 py-1 text-center">{{ $index + 1 }}</td>
                        <td class="border px-2 py-1">{{ $item->product_code }}</td>
                        <td class="border px-2 py-1">{{ $item->product_name }}</td>
                        <td class="border px-2 py-1 text-right">{{ $item->quantity }}</td>
                        <td class="border px-2 py-1 text-right">₹{{ number_format($item->rate, 2) }}</td>
                        <td class="border px-2 py-1 text-right">₹{{ number_format($item->total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="flex justify-end space-y-1 text-sm">
            <div class="w-full md:w-1/2 space-y-1">
                <div class="flex justify-between">
                    <span>Subtotal</span>
                    <span>₹{{ number_format($invoice->subtotal_amount, 2) }}</span>
                </div>
                <div class="flex justify-between">
                    <span>CGST ({{ $invoice->cgst_percent }}%)</span>
                    <span>₹{{ number_format(($invoice->subtotal_amount * $invoice->cgst_percent) / 100, 2) }}</span>
                </div>
                <div class="flex justify-between">
                    <span>SGST ({{ $invoice->sgst_percent }}%)</span>
                    <span>₹{{ number_format(($invoice->subtotal_amount * $invoice->sgst_percent) / 100, 2) }}</span>
                </div>
                <div class="flex justify-between">
                    <span>IGST ({{ $invoice->igst_percent }}%)</span>
                    <span>₹{{ number_format(($invoice->subtotal_amount * $invoice->igst_percent) / 100, 2) }}</span>
                </div>
                <div class="border-t mt-2 flex justify-between font-bold text-lg">
                    <span>Total</span>
                    <span>₹{{ number_format($invoice->total_amount, 2) }}</span>
                </div>
            </div>
        </div>

        <div class="text-center mt-6">
            <button onclick="window.print()" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">🖨 Print
                Invoice</button>
        </div>
    </div>
</x-layout.default>
