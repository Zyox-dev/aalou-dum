@props(['approval' => null])

@php $editing = isset($approval); @endphp

@if ($errors->any())
    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 p-3 rounded">
        <ul class="list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div x-data="{ type: '{{ old('approval_type', $approval->approval_type ?? '1') }}' }">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Approval Type -->
        <div>
            <label class="block font-medium">Approval Type</label>
            <select name="approval_type" x-model="type" class="w-full border p-2 rounded">
                @foreach ($types as $type)
                    <option value={{ $type['value'] }}>{{ $type['label'] }}</option>
                @endforeach
            </select>
            @error('approval_type')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Date -->
        <div>
            <label class="block font-medium">Approval Date</label>
            <input type="date" name="date" value="{{ old('date', optional($approval?->date)->format('Y-m-d')) }}"
                class="w-full border p-2 rounded">
            @error('date')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Rate -->
        <div>
            <label class="block font-medium">Rate</label>
            <input type="number" step="0.01" name="rate" value="{{ old('rate', $approval->rate ?? '') }}"
                class="w-full border p-2 rounded">
            @error('rate')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Quantity -->
        <div>
            <label class="block font-medium">
                Quantity (<span x-text="type === '1' ? 'gram' : 'karrot'"></span>)
            </label>
            <input type="number" step="0.01" name="qty" value="{{ old('qty', $approval->qty ?? '') }}"
                class="w-full border p-2 rounded">
            @error('qty')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- GST -->
        <div>
            <label class="block font-medium">GST (%)</label>
            <input type="number" step="0.01" name="gst_percent"
                value="{{ old('gst_percent', $approval->gst_percent ?? '') }}" class="w-full border p-2 rounded">
            @error('gst_percent')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="mt-6">
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded">
            {{ $editing ? 'Update' : 'Save' }}
        </button>
    </div>
</div>
