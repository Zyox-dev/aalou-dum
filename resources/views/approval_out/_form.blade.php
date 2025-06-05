@props(['approval' => null])

@php $editing = isset($approval); @endphp

@php
    $existingName = old('labour_name', $approval?->labour?->name);
    $existingMobile = old('labour_mobile', $approval?->labour?->mobile);
@endphp

<div x-data="{
    type: '{{ old('approval_type', $approval->approval_type ?? '1') }}',
    labourSuggestions: [],
    labourName: '{{ $existingName }}',
    labourMobile: '{{ $existingMobile }}',
    selectedLabourId: '{{ old('labour_id', $approval?->labour_id ?? '') }}',

    fetchSuggestions() {
        if (this.labourName.length < 2) {
            this.labourSuggestions = [];
            return;
        }
        fetch('/labours/search?name=' + this.labourName)
            .then(res => res.json())
            .then(data => this.labourSuggestions = data);
    },

    selectSuggestion(labour) {
        this.labourName = labour.name;
        this.labourMobile = labour.mobile;
        this.selectedLabourId = labour.id;
        this.labourSuggestions = [];
    }
}" @click.outside="labourSuggestions = []">

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

        <!-- Approval Date -->
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
                Quantity (<span x-text="type === '1' ? 'gram' : 'carat'"></span>)
            </label>
            <input type="number" step="0.01" name="qty" value="{{ old('qty', $approval->qty ?? '') }}"
                class="w-full border p-2 rounded">
            @error('qty')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Labour Name -->
        <div class="relative">
            <label class="block font-medium">Labour Name</label>
            <input type="text" name="labour_name" autocomplete='off' x-model="labourName"
                @input.debounce.300ms="fetchSuggestions" class="w-full border p-2 rounded">
            <ul x-show="labourSuggestions.length"
                class="absolute bg-white border mt-1 w-full z-10 rounded shadow text-sm">
                <template x-for="labour in labourSuggestions" :key="labour.id">
                    <li @click="selectSuggestion(labour)" class="px-4 py-2 hover:bg-gray-100 cursor-pointer"
                        x-text="labour.name + ' (' + labour.mobile + ')'"></li>
                </template>
            </ul>
            @error('labour_name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Labour Mobile -->
        <div>
            <label class="block font-medium">Labour Mobile</label>
            <input type="text" name="labour_mobile" x-model="labourMobile" class="w-full border p-2 rounded">
            @error('labour_mobile')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Hidden Labour ID (optional, will be sent if match found) -->
    <input type="hidden" name="labour_id" x-model="selectedLabourId">

    <div class="mt-6">
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded">
            {{ $editing ? 'Update' : 'Save' }}
        </button>
    </div>
</div>
