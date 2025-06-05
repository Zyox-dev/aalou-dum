<x-layout.default>
    <div class="panel mt-4">
        <h5 class="font-semibold text-lg dark:text-white-light mb-4">Edit Product</h5>

        <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('products._form', ['product' => $product])
        </form>
    </div>
</x-layout.default>
