<x-layout.default>
    <div class="p-4">
        <div class="text-lg font-semibold mb-4">All Invoices</div>

        @if (session('success'))
            <div class="mb-4 text-green-600 font-medium">{{ session('success') }}</div>
        @endif

        <table class="w-full border border-collapse text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-2 py-1">#</th>
                    <th class="border px-2 py-1">Customer</th>
                    <th class="border px-2 py-1">Date</th>
                    <th class="border px-2 py-1 text-right">Total</th>
                    <th class="border px-2 py-1 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($invoices as $index => $invoice)
                    <tr>
                        <td class="border px-2 py-1 text-center">{{ $index + 1 }}</td>
                        <td class="border px-2 py-1">{{ $invoice->customer_name }}</td>
                        <td class="border px-2 py-1">{{ $invoice->purchase_date }}</td>
                        <td class="border px-2 py-1 text-right">₹{{ number_format($invoice->total_amount, 2) }}</td>
                        <td class="border px-2 py-1 text-center space-x-2">
                            <a href="{{ route('invoices.print', $invoice->id) }}" target="_blank"
                                class="text-blue-600 hover:underline">Print</a>

                            <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST"
                                class="inline-block" onsubmit="return confirm('Delete this invoice?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="border px-2 py-2 text-center text-gray-500">No invoices found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layout.default>
