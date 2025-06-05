@props(['product' => null, 'carats' => [], 'adminPercent' => 0, 'marginPercent' => 0])

@php
    $editing = isset($product);
@endphp


<div x-data="{
    gold_qty: {{ old('gold_qty', $product->gold_qty ?? 0) }},
    gold_rate: {{ old('gold_rate', $product->gold_rate ?? 0) }},
    diamond_qty: {{ old('diamond_qty', $product->diamond_qty ?? 0) }},
    diamond_rate: {{ old('diamond_rate', $product->diamond_rate ?? 0) }},
    color_stone_qty: {{ old('color_stone_qty', $product->color_stone_qty ?? 0) }},
    color_stone_rate: {{ old('color_stone_rate', $product->color_stone_rate ?? 0) }},
    labour_count: {{ old('labour_count', $product->labour_count ?? 0) }},
    labour_rate: {{ old('labour_rate', $product->labour_rate ?? 0) }},
    admin: {{ $adminPercent }},
    margin: {{ $marginPercent }},

    calculate(field) {
        this[field] = parseFloat(this[field]) || 0;
    },

    get gold_total() {
        return (this.gold_qty * this.gold_rate).toFixed(2);
    },
    get diamond_total() {
        return (this.diamond_qty * this.diamond_rate).toFixed(2);
    },
    get color_stone_total() {
        return (this.color_stone_qty * this.color_stone_rate).toFixed(2);
    },
    get labour_total() {
        return (this.labour_count * this.labour_rate).toFixed(2);
    },
    get total_amount() {
        return (
            parseFloat(this.gold_total) +
            parseFloat(this.diamond_total) +
            parseFloat(this.color_stone_total) +
            parseFloat(this.labour_total)
        ).toFixed(2);
    },
    get gross_amount() {
        return (
            parseFloat(this.total_amount) +
            parseFloat(this.total_amount) * this.admin / 100
        ).toFixed(2);
    },
    get mrp() {
        return (
            parseFloat(this.gross_amount) +
            parseFloat(this.gross_amount) * this.margin / 100
        ).toFixed(2);
    }
}">

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <!-- Gold Section -->
        <div>
            <label>Gold Qty (grams)</label>
            <input type="number" name="gold_qty" x-model="gold_qty" step="0.01" @input="calculate('gold_qty')"
                class="form-input">
            @error('gold_qty')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label>Gold Rate per gram</label>
            <input type="number" name="gold_rate" x-model="gold_rate" step="0.01" @input="calculate('gold_rate')"
                class="form-input">
            @error('gold_rate')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label>Gold Carat</label>
            <select name="gold_carat" class="form-input">
                @foreach ($carats as $carat)
                    <option value="{{ $carat }}" @selected(old('gold_carat', $product->gold_carat ?? '') == $carat)>{{ $carat }}</option>
                @endforeach
            </select>
            @error('gold_carat')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label>Total Gold Amount</label>
            <input type="text" :value="gold_total" class="form-input bg-gray-100" readonly>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Diamond -->
        <div>
            <label>Diamond Qty (carat)</label>
            <input type="number" name="diamond_qty" x-model="diamond_qty" step="0.01"
                @input="calculate('diamond_qty')" class="form-input">
            @error('diamond_qty')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label>Diamond Rate</label>
            <input type="number" name="diamond_rate" x-model="diamond_rate" step="0.01"
                @input="calculate('diamond_rate')" class="form-input">
            @error('diamond_rate')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label>Total Diamond Amount</label>
            <input type="text" :value="diamond_total" class="form-input bg-gray-100" readonly>
        </div>

        <!-- Color Stone -->
        <div>
            <label>Color Stone Qty (carat)</label>
            <input type="number" name="color_stone_qty" x-model="color_stone_qty" step="0.01"
                @input="calculate('color_stone_qty')" class="form-input">
            @error('color_stone_qty')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label>Color Stone Rate</label>
            <input type="number" name="color_stone_rate" x-model="color_stone_rate" step="0.01"
                @input="calculate('color_stone_rate')" class="form-input">
            @error('color_stone_rate')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label>Total Color Stone Amount</label>
            <input type="text" :value="color_stone_total" class="form-input bg-gray-100" readonly>
        </div>

        <!-- Labour -->
        <div>
            <label>Labour Count</label>
            <input type="number" name="labour_count" x-model="labour_count" step="1"
                @input="calculate('labour_count')" class="form-input">
            @error('labour_count')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label>Rate per Labour</label>
            <input type="number" name="labour_rate" x-model="labour_rate" step="0.01"
                @input="calculate('labour_rate')" class="form-input">
            @error('labour_rate')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label>Total Labour Amount</label>
            <input type="text" :value="labour_total" class="form-input bg-gray-100" readonly>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Summary -->
        <div>
            <label>Total Amount</label>
            <input type="text" :value="total_amount" name="total_amount" class="form-input bg-gray-100" readonly>
        </div>
        <div>
            <label>Gross Amount (+{{ $adminPercent }}%)</label>
            <input type="text" :value="gross_amount" name="gross_amount" class="form-input bg-gray-100" readonly>
        </div>
        <div>
            <label>MRP (+{{ $marginPercent }}%)</label>
            <input type="text" :value="mrp" name="mrp" class="form-input bg-gray-100" readonly>
        </div>
    </div>
    <div class="grid  gap-4">
        <div class="md:col-span-2">
            <label>Product Name</label>
            <input name="name" class="form-input" value={{ old('name', $product->name ?? '') }}>
            @error('name')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <!-- Description -->
        <div class="md:col-span-2">
            <label>Description (optional)</label>
            <textarea name="description" class="form-input">{{ old('description', $product->description ?? '') }}</textarea>
            @error('description')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Images -->
        <div class="md:col-span-2">
            <label>Product Images (optional)</label>
            <input type="file" name="images[]" multiple accept="image/*" class="form-input">
            @error('images')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Show In Frontend -->
        <div class="md:col-span-2">
            <label class="inline-flex items-center">
                <input type="checkbox" name="show_in_frontend" value="1" class="form-checkbox"
                    {{ old('show_in_frontend', $product->show_in_frontend ?? false) ? 'checked' : '' }}>
                <span class="ml-2">Show in Frontend</span>
            </label>
        </div>

    </div>

    <div class="mt-6">
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded">
            {{ $editing ? 'Update' : 'Save' }}
        </button>
    </div>
</div>
