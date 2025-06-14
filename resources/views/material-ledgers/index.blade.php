<x-layout.default>
    <div class="panel mt-6">
        <h5 class="font-semibold text-lg mb-4 dark:text-white-light">Ledger</h5>

        <!-- Filters (same as before) -->
        @include('material-ledgers._filters', ['labours' => $labours])

        <!-- Double Entry Table -->
        <div class="overflow-x-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Debit (Jama) -->
                <div>
                    <h6 class="font-semibold mb-2">Receipt / Jama</h6>
                    <table class="table-auto w-full border">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="p-2">Date</th>
                                <th class="p-2">Narration</th>
                                <th class="p-2">Material Type</th>
                                <th class="p-2">Quantity</th>
                                <th class="p-2">Amount</th>
                                <th class="p-2">Labour</th>
                                {{-- <th class="p-2">Ref</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @php $debitTotal = 0; @endphp
                            @foreach ($ledgers->filter(fn($e) => in_array($e->entry_type->value, [1, 3])) as $entry)
                                @php $debitTotal += $entry->quantity; @endphp
                                @php
                                    $amount = match ($entry->entry_type->value) {
                                        1 => $entry->reference->gross_amount,
                                        2 => $entry->reference->rate * $entry->reference->rate,
                                        3 => $entry->reference->gross_amount,
                                        4 => $entry->reference->total_amount,
                                    };
                                @endphp

                                <tr class="border-t">
                                    <td class="p-2">{{ $entry->date->format('d-m-Y') }}</td>
                                    <td class="p-2">{{ $entry->entry_type->label() }}</td>
                                    <td class="p-2">{{ $entry->material_type->label() }}</td>
                                    <td class="p-2 text-right">
                                        {{ number_format($entry->quantity, 2) . ' ' . $entry->material_type->unit() }}
                                    </td>
                                    <td class="p-2">{{ $amount }}</td>
                                    <td class="p-2">{{ $entry->labour?->name }}</td>
                                    {{-- <td class="p-2">{{ $entry->reference?->reference_no ?? '—' }}</td> --}}
                                </tr>
                            @endforeach
                            <tr class="font-semibold border-t">
                                <td colspan="3" class="p-2 text-right">Total</td>
                                <td colspan="2" class="p-2 text-right">
                                    {{ number_format($debitTotal, 2) . ' Gram / Carat' }}</td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Credit (Udhar) -->
                <div>
                    <h6 class="font-semibold mb-2">Issue / Udhar</h6>
                    <table class="table-auto w-full border">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="p-2">Date</th>
                                <th class="p-2">Narration</th>
                                <th class="p-2">Material Type</th>

                                <th class="p-2">Quantity</th>
                                <th class="p-2">Amount</th>
                                <th class="p-2">Labour</th>
                                {{-- <th class="p-2">Ref</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @php $creditTotal = 0; @endphp

                            @foreach ($ledgers->filter(fn($e) => in_array($e->entry_type->value, [2, 4])) as $entry)
                                @php $creditTotal += $entry->quantity; @endphp
                                @php
                                    $amount = match ($entry->entry_type->value) {
                                        1 => $entry->reference->gross_amount,
                                        2 => $entry->reference->rate * $entry->reference->rate,
                                        3 => $entry->reference->gross_amount,
                                        4 => $entry->reference->total_amount,
                                    };
                                @endphp
                                <tr class="border-t">
                                    <td class="p-2">{{ $entry->date->format('d-m-Y') }}</td>
                                    <td class="p-2">{{ $entry->entry_type->label() }}</td>
                                    <td class="p-2">{{ $entry->material_type->label() }}</td>

                                    <td class="p-2 text-right">
                                        {{ number_format($entry->quantity, 2) . ' ' . $entry->material_type->unit() }}
                                    </td>
                                    <td class="p-2">{{ $amount }}</td>
                                    <td class="p-2">{{ $entry->labour?->name }}</td>
                                    {{-- <td class="p-2">{{ $entry->reference?->reference_no ?? '—' }}</td> --}}
                                </tr>
                            @endforeach
                            <tr class="font-semibold border-t">
                                <td colspan="3" class="p-2 text-right">Total</td>
                                <td colspan="2" class="p-2 text-right">
                                    {{ number_format($creditTotal, 2) . ' Gram / Carat' }}</td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Balance Summary -->
            <div class="mt-6 text-right font-bold text-lg">
                Net Balance = {{ number_format($debitTotal - $creditTotal, 2) }}
            </div>
        </div>
    </div>
</x-layout.default>
