<x-layout.default>
    <div class="p-4" x-data="invoiceForm()">
        <div class="text-lg font-semibold mb-4">Create Invoice</div>

        @if ($errors->any())
            <div class="mb-4 text-red-600 font-medium">Please fix the errors below.</div>
        @endif

        <form method="POST" action="{{ route('invoices.store') }}">
            @csrf

            {{-- Customer Info --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block mb-1 font-medium">Customer Name <span class="text-red-500">*</span></label>
                    <input type="text" name="customer_name" value="{{ old('customer_name') }}"
                        class="form-input w-full" required>
                    @error('customer_name')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block mb-1 font-medium">Purchase Date <span class="text-red-500">*</span></label>
                    <input type="date" name="purchase_date" value="{{ old('purchase_date') }}"
                        class="form-input w-full" required>
                    @error('purchase_date')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block mb-1 font-medium">Customer Address</label>
                    <input type="text" name="customer_address" value="{{ old('customer_address') }}"
                        class="form-input w-full">
                </div>

                <div>
                    <label class="block mb-1 font-medium">Customer GSTIN</label>
                    <input type="text" name="customer_gstin" value="{{ old('customer_gstin') }}"
                        class="form-input w-full">
                </div>

                <div>
                    <label class="block mb-1 font-medium">Customer PAN</label>
                    <input type="text" name="customer_pan" value="{{ old('customer_pan') }}"
                        class="form-input w-full">
                </div>
            </div>

            {{-- GST Section --}}
            <div class="grid grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block mb-1 font-medium">CGST %</label>
                    <input type="number" name="cgst_percent" x-model="cgst" value="{{ old('cgst_percent', 0) }}"
                        class="form-input w-full" min="0" step="0.01">
                    @error('cgst_percent')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block mb-1 font-medium">SGST %</label>
                    <input type="number" name="sgst_percent" x-model="sgst" value="{{ old('sgst_percent', 0) }}"
                        class="form-input w-full" min="0" step="0.01">
                    @error('sgst_percent')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block mb-1 font-medium">IGST %</label>
                    <input type="number" name="igst_percent" x-model="igst" value="{{ old('igst_percent', 0) }}"
                        class="form-input w-full" min="0" step="0.01">
                    @error('igst_percent')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Items --}}
            <div class="mb-4">
                <label class="block mb-2 font-medium">Invoice Items</label>

                <template x-for="(item, index) in items" :key="index">
                    <div class="grid grid-cols-5 gap-2 items-center mb-2">
                        <input type="text" x-model="item.product_code" @change="fetchProduct(index)"
                            :name="'items[' + index + '][product_code]'" class="form-input" placeholder="Product Code"
                            required>

                        <input type="text" x-model="item.product_name" :name="'items[' + index + '][product_name]'"
                            class="form-input bg-gray-100" placeholder="Product Name" readonly>

                        <input type="number" x-model="item.quantity" @input="updateTotal(index)"
                            :name="'items[' + index + '][quantity]'" class="form-input" placeholder="Qty" min="0.01"
                            step="0.01" required>

                        <input type="text" x-model="item.rate" :name="'items[' + index + '][rate]'"
                            class="form-input bg-gray-100" placeholder="Rate" readonly>

                        <input type="text" x-model="item.total" :name="'items[' + index + '][total]'"
                            class="form-input bg-gray-100" placeholder="Total" readonly>
                    </div>
                </template>

                <button type="button" @click="addItem()"
                    class="mt-2 px-4 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">+ Add Item</button>
            </div>

            {{-- Totals --}}
            <div class="flex justify-end mb-4">
                <div class="w-full md:w-1/2 space-y-1">
                    <div class="flex justify-between">
                        <span class="font-medium">Subtotal:</span>
                        <span x-text="subtotal.toFixed(2)"></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium">GST Amount:</span>
                        <span x-text="gstAmount.toFixed(2)"></span>
                    </div>
                    <div class="flex justify-between font-bold text-lg border-t pt-2">
                        <span>Total:</span>
                        <span x-text="totalAmount.toFixed(2)"></span>
                    </div>
                </div>
            </div>

            {{-- Submit --}}
            <div class="text-right">
                <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700">Save
                    Invoice</button>
            </div>
        </form>
    </div>

    {{-- Alpine.js --}}
    <script>
        function invoiceForm() {
            return {
                cgst: {{ old('cgst_percent', 0) }},
                sgst: {{ old('sgst_percent', 0) }},
                igst: {{ old('igst_percent', 0) }},
                items: [],
                get subtotal() {
                    return this.items.reduce((sum, item) => sum + (parseFloat(item.total) || 0), 0);
                },
                get gstAmount() {
                    const gstPercent = parseFloat(this.cgst) + parseFloat(this.sgst) + parseFloat(this.igst);
                    return (this.subtotal * gstPercent) / 100;
                },
                get totalAmount() {
                    return this.subtotal + this.gstAmount;
                },
                addItem() {
                    this.items.push({
                        product_code: '',
                        product_name: '',
                        quantity: 1,
                        rate: 0,
                        total: 0
                    });
                },
                fetchProduct(index) {
                    const code = this.items[index].product_code;
                    fetch(`/products/by-code/${code}`)
                        .then(res => res.json())
                        .then(data => {
                            if (data && data.name) {
                                this.items[index].product_name = data.name;
                                this.items[index].rate = data.mrp;
                                this.updateTotal(index);
                            }
                        });
                },
                updateTotal(index) {
                    const item = this.items[index];
                    item.total = (parseFloat(item.rate || 0) * parseFloat(item.quantity || 0)).toFixed(2);
                }
            }
        }
    </script>
</x-layout.default>
