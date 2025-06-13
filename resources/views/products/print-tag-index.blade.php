<x-layout.default>
    <div class="panel mt-4">

        <form id="print-form" method="POST" action="{{ route('products.print-tags-store') }}" target="_blank">
            @csrf
            <input type="hidden" name="product_ids" id="product-ids">
            <div class="flex justify-between items-center mb-4">
                <h5 class="font-semibold text-lg dark:text-white-light">Product List</h5>
                <div class="space-x-2">
                    <button type="submit" class="btn btn-primary">Print
                        Tags</button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="table-auto w-full border">
                    <thead>
                        <tr class="bg-gray-200 text-left">
                            <th class="p-2">
                                <input type="checkbox" id="select-all" />
                            </th>
                            <th class="p-2">Product No</th>
                            <th class="p-2">Name</th>
                            <th class="p-2">Gold (g)</th>
                            <th class="p-2">Diamond (ct)</th>
                            <th class="p-2">Color Stone (ct)</th>
                            <th class="p-2">Total</th>
                            <th class="p-2">Gross</th>
                            <th class="p-2">MRP</th>
                            <th class="p-2">Frontend</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr class="border-t">
                                <td class="p-2">
                                    <input type="checkbox" name="selected_products[]" value="{{ $product->id }}"
                                        class="product-checkbox" />
                                </td>
                                <td class="p-2">{{ $product->product_no }}</td>
                                <td class="p-2">{{ $product->name }}</td>
                                <td class="p-2">{{ $product->gold_qty }}g ({{ $product->gold_carat }})</td>
                                <td class="p-2">{{ $product->diamond_qty }}ct</td>
                                <td class="p-2">{{ $product->color_stone_qty }}ct</td>
                                <td class="p-2">₹{{ number_format($product->total_amount, 2) }}</td>
                                <td class="p-2">₹{{ number_format($product->gross_amount, 2) }}</td>
                                <td class="p-2">₹{{ number_format($product->mrp, 2) }}</td>
                                <td class="p-2">{{ $product->show_in_frontend ? 'Yes' : 'No' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="p-4 text-center text-gray-600">No products found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('select-all').addEventListener('change', function() {
            document.querySelectorAll('.product-checkbox').forEach(cb => cb.checked = this.checked);
        });

        document.getElementById('print-form').addEventListener('submit', function(e) {
            let selected = Array.from(document.querySelectorAll('.product-checkbox:checked')).map(cb => cb.value);
            if (selected.length === 0) {
                e.preventDefault();
                alert("Select at least one product.");
            } else {
                document.getElementById('product-ids').value = selected.join(',');
            }
        });
    </script>
</x-layout.default>
