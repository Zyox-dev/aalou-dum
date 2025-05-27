@props(['purchase' => null])

@php
    $editing = isset($purchase);
@endphp

@if ($errors->any())
    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 p-3 rounded">
        <ul class="list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div x-data="{
    type: '{{ old('purchase_type', $purchase->purchase_type->value ?? '1') }}',
    rate: {{ old('rate_per_unit', $purchase->rate_per_unit ?? 0) }},
    karrot: {{ old('karrot', $purchase->karrot ?? 0) }},
    weight: {{ old('weight_in_gram', $purchase->weight_in_gram ?? 0) }},
    total: 0,
    calculateTotal() {
        if (this.type === '1') {
            this.total = (this.rate * this.weight).toFixed(2);
        } else {
            this.total = (this.rate * this.karrot).toFixed(2);
        }
    }
}" x-init="calculateTotal()" @input.window="calculateTotal()">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block font-medium">Purchase Type</label>

            <select name="purchase_type" x-model="type" class="w-full border p-2 rounded">
                @foreach ($types as $type)
                    <option value={{ $type['value'] }}>{{ $type['label'] }}</option>
                @endforeach
            </select>
            @error('purchase_type')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block font-medium">Purchase Date</label>
            <input type="date" name="purchase_date"
                value="{{ old('purchase_date', optional($purchase?->purchase_date)->format('Y-m-d')) }}"
                class="w-full border p-2 rounded" required>
            @error('purchase_date')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block font-medium">Rate</label>
            <input type="number" step="0.01" name="rate_per_unit" x-model="rate" @input="calculateTotal"
                class="w-full border p-2 rounded" required>
            @error('rate_per_unit')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block font-medium">Karrot</label>
            <input type="number" step="0.01" name="karrot" x-model="karrot" @input="calculateTotal"
                class="w-full border p-2 rounded" required>
            @error('karrot')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div x-show="type === '1'" class="transition-all duration-300">
            <label class="block font-medium">Weight (grams)</label>
            <input type="number" step="0.01" name="weight_in_gram" x-model="weight" @input="calculateTotal"
                class="w-full border p-2 rounded">
            @error('weight_in_gram')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div x-show="type === '1'" class="transition-all duration-300">
            <label class="block font-medium">GST (%)</label>
            <input type="number" step="0.01" name="gst_percent"
                value="{{ old('gst_percent', $purchase->gst_percent ?? '') }}" class="w-full border p-2 rounded">
            @error('gst_percent')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div x-show="type === '3'" class="transition-all duration-300 md:col-span-2">
            <label class="block font-medium">Color Stone Name</label>
            <input type="text" name="color_stone_name"
                value="{{ old('color_stone_name', $purchase->color_stone_name ?? '') }}"
                class="w-full border p-2 rounded">
            @error('color_stone_name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="md:col-span-2">
            <label class="block font-medium">Total Amount</label>
            <input type="text" x-model="total" name="amount_total" readonly
                class="w-full border p-2 bg-gray-100 rounded">
        </div>
    </div>

    <div class="mt-6">
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded">
            {{ $editing ? 'Update' : 'Save' }}
        </button>
    </div>
</div>
