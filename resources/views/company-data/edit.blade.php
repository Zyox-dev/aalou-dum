<x-layout.default>

    <h2 class="text-xl font-bold mb-4">Company Profile</h2>

    <form action="{{ route('company-data.update') }}" method="POST" enctype="multipart/form-data"
        class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @csrf

        <div>
            <label class="block font-medium">Company Name</label>
            <input type="text" name="company_name" value="{{ old('company_name', $data->company_name) }}"
                class="w-full border p-2 rounded">
            @error('company_name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block font-medium">Address</label>
            <textarea name="address" class="w-full border p-2 rounded">{{ old('address', $data->address) }}</textarea>
            @error('address')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block font-medium">GSTIN</label>
            <input type="text" name="gstin" value="{{ old('gstin', $data->gstin) }}"
                class="w-full border p-2 rounded">
            @error('gstin')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block font-medium">PAN Number</label>
            <input type="text" name="pan_no" value="{{ old('pan_no', $data->pan_no) }}"
                class="w-full border p-2 rounded">
            @error('pan_no')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block font-medium">Admin Cost (%)</label>
            <input type="number" name="admin_cost_percent" step="0.01"
                value="{{ old('admin_cost_percent', $data->admin_cost_percent) }}" class="w-full border p-2 rounded">
            @error('admin_cost_percent')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block font-medium">Margin (%)</label>
            <input type="number" name="margin_percent" step="0.01"
                value="{{ old('margin_percent', $data->margin_percent) }}" class="w-full border p-2 rounded">
            @error('margin_percent')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="md:col-span-2">
            <label class="block font-medium">Available Carats (comma separated)</label>
            <input type="text" name="carats" value="{{ old('carats', $data->carats) }}"
                class="w-full border p-2 rounded">
            <small class="text-gray-500">Example: 18K,20K,22K,24K</small>
            @error('carats')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block font-medium">Company Logo</label>
            <input type="file" name="logo" class="w-full border p-2 rounded">
            @error('logo')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror

            @if ($data->logo)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $data->logo) }}" alt="Company Logo" class="h-16">
                </div>
            @endif
        </div>

        <div class="md:col-span-2 mt-4">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded">Update</button>
        </div>
    </form>

</x-layout.default>
