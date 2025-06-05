<x-layout.default>

    <div class="panel mt-6">
        <h5 class="font-semibold text-lg mb-4">📒 Material Ledger</h5>

        {{-- ✅ Summary Cards --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div class="p-4 bg-white rounded shadow">
                <div class="text-sm text-gray-500">Total Purchase</div>
                <div class="text-xl font-bold">{{ $summary['total_purchase'] }} gm/ct</div>
            </div>
            <div class="p-4 bg-white rounded shadow">
                <div class="text-sm text-gray-500">Total Approval Out</div>
                <div class="text-xl font-bold">{{ $summary['total_out'] }} gm/ct</div>
            </div>
            <div class="p-4 bg-white rounded shadow">
                <div class="text-sm text-gray-500">Total Received (In)</div>
                <div class="text-xl font-bold">{{ $summary['total_in'] }} gm/ct</div>
            </div>
            <div class="p-4 bg-white rounded shadow">
                <div class="text-sm text-gray-500">With Labour / In Inventory</div>
                <div class="text-xl font-bold">
                    {{ $summary['with_labour'] }} / {{ $summary['in_inventory'] }}
                </div>
            </div>
        </div>
        {{-- ✅ Filters --}}
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <select name="material_type" class="form-select">
                <option value="">All Materials</option>
                @foreach ($materialTypes as $type)
                    <option value="{{ $type->value }}" {{ $request->material_type == $type->value ? 'selected' : '' }}>
                        {{ $type->label() }}
                    </option>
                @endforeach
            </select>

            <select name="labour_id" class="form-select">
                <option value="">All Labours</option>
                @foreach ($labours as $labour)
                    <option value="{{ $labour->id }}" {{ $request->labour_id == $labour->id ? 'selected' : '' }}>
                        {{ $labour->name }}
                    </option>
                @endforeach
            </select>

            <input type="date" name="from_date" value="{{ $request->from_date }}" class="form-input"
                placeholder="From Date">
            <input type="date" name="to_date" value="{{ $request->to_date }}" class="form-input"
                placeholder="To Date">

            <button class="btn btn-primary col-span-1 md:col-span-4 w-full">Apply Filters</button>
        </form>
        {{-- ✅ Ledger Table --}}
        <div class="overflow-auto">
            <table class="table-auto w-full border">
                <thead class="bg-gray-100 text-left">
                    <tr>
                        <th class="p-2">Date</th>
                        <th class="p-2">Material</th>
                        <th class="p-2">Entry Type</th>
                        <th class="p-2">Quantity</th>
                        <th class="p-2">Labour</th>
                        <th class="p-2">Remarks</th>
                        <th class="p-2">Reference</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ledgers as $ledger)
                        <tr class="border-b">
                            <td class="p-2">{{ $ledger->date }}</td>
                            <td class="p-2">{{ $ledger->material_type->label() }}</td>
                            <td class="p-2">{{ $ledger->entry_type->label() }}</td>
                            <td class="p-2">{{ $ledger->quantity }}</td>
                            <td class="p-2">{{ $ledger->labour?->name ?? '-' }}</td>
                            <td class="p-2">{{ $ledger->remarks ?? '-' }}</td>
                            <td class="p-2 text-xs">{{ $ledger->reference_id }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center p-4">No records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</x-layout.default>
