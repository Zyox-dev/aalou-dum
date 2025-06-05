<x-layout.default>
    <div class="panel mt-4">
        <h5 class="font-semibold text-lg dark:text-white-light mb-4">Add Product</h5>

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('products._form', ['product' => null])
        </form>
    </div>
</x-layout.default>
