<x-layout.default>
    <div class="panel mt-4">
        <h5 class="font-semibold text-lg dark:text-white-light mb-4">Product Details</h5>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div><strong>Product No:</strong> {{ $product->product_no }}</div>
            <div><strong>Gold:</strong> {{ $product->gold_quantity }}g ({{ $product->gold_carat }}) @
                ₹{{ $product->gold_rate }}</div>
            <div><strong>Diamond:</strong> {{ $product->diamond_quantity }}ct @ ₹{{ $product->diamond_rate }}</div>
            <div><strong>Color Stone:</strong> {{ $product->colorstone_quantity }}ct @ ₹{{ $product->colorstone_rate }}
            </div>
            <div><strong>Labour Charges:</strong> {{ $product->labour_count }} x ₹{{ $product->labour_rate }}</div>
            <div><strong>Total:</strong> ₹{{ $product->total_amount }}</div>
            <div><strong>Gross Amount:</strong> ₹{{ $product->gross_amount }}</div>
            <div><strong>MRP:</strong> ₹{{ $product->mrp }}</div>
            <div><strong>Show in Frontend:</strong> {{ $product->show_in_frontend ? 'Yes' : 'No' }}</div>
            <div class="md:col-span-2">
                <strong>Description:</strong>
                <p class="text-gray-700 mt-2">{{ $product->description }}</p>
            </div>

            <div class="md:col-span-2 mt-4">
                <strong>Images:</strong>
                <div class="flex flex-wrap gap-4 mt-2">
                    @foreach ($product->images as $image)
                        <img src="{{ asset('storage/' . $image->path) }}" alt="Image"
                            class="w-32 h-32 object-cover border rounded">
                    @endforeach
                </div>
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
</x-layout.default>
