<x-layout.default>
    <div class="panel mt-4">

        <div class="flex justify-between items-center mb-4">
            <h5 class="font-semibold text-lg dark:text-white-light">Product List</h5>
            <div class="space-x-2">
                <a href="{{ route('products.create') }}" class="btn btn-primary">Add Product</a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="table-auto w-full border">
                <thead>
                    <tr class="bg-gray-200 text-left">
                        <th class="p-2">Product No</th>
                        <th class="p-2">Name</th>
                        <th class="p-2">Gold (g)</th>
                        <th class="p-2">Diamond (ct)</th>
                        <th class="p-2">Color Stone (ct)</th>
                        <th class="p-2">Total</th>
                        <th class="p-2">Gross</th>
                        <th class="p-2">MRP</th>
                        <th class="p-2">Frontend</th>
                        <th class="p-2 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr class="border-t">
                            <td class="p-2">{{ $product->product_no }}</td>
                            <td class="p-2">{{ $product->name }}</td>
                            <td class="p-2">{{ $product->gold_qty }}g ({{ $product->gold_carat }})</td>
                            <td class="p-2">{{ $product->diamond_qty }}ct</td>
                            <td class="p-2">{{ $product->color_stone_qty }}ct</td>
                            <td class="p-2">₹{{ number_format($product->total_amount, 2) }}</td>
                            <td class="p-2">₹{{ number_format($product->gross_amount, 2) }}</td>
                            <td class="p-2">₹{{ number_format($product->mrp, 2) }}</td>
                            <td class="p-2">{{ $product->show_in_frontend ? 'Yes' : 'No' }}</td>
                            <td class="p-2 text-center">
                                <a href="{{ route('products.edit', $product) }}" class="text-blue-600">Edit</a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Are you sure?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 ml-2">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="p-4 text-center text-gray-600">No products found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layout.default>
