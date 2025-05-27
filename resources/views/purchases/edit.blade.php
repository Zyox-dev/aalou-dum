<x-layout.default>
    <div class="panel">
        <div class="flex items-center justify-between mb-5">
            <h5 class="font-semibold text-lg dark:text-white-light">Edit Purchase</h5>
        </div>
        <div class="mb-5">
            <form class="space-y-5" action="{{ route('purchases.update', $purchase) }}" method="POST">
                @csrf
                @method('PUT')
                @include('purchases._form', ['purchase' => $purchase])
            </form>
        </div>
    </div>
</x-layout.default>
