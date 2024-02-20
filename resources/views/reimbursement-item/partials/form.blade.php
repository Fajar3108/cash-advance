@php
$values = [
'note' => '',
'date' => date('Y-m-d'),
'price' => '',
];

if (isset($item)) {
$values = [
'note' => $item->note,
'date' => $item->date,
'price' => $item->price,
];
}
@endphp
<div class="mb-5">
    <label for="note" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Keterangan</label>
    <textarea id="note" rows="4" name="note"
        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300">{{ old('note') ?? $values['note'] }}</textarea>
    @error('note')
    <small class=" text-red-600">{{ $message }}</small>
    @enderror
</div>
<div class="mb-5">
    <label for="date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal</label>
    <input type="date" id="date" name="date"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required
        value="{{ old('date') ?? $values['date'] }}">
    @error('date')
    <small class="text-red-600">{{ $message }}</small>
    @enderror
</div>
<div class="mb-5">
    <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Harga</label>
    <input type="text" id="price-currency" data-format="currency" data-target="price"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required
        value="{{ old('price') ?? $values['price'] }}">
    <input type="hidden" id="price" name="price" value="{{ old('price') ?? $values['price'] }}">
    @error('price')
    <small class="text-red-600">{{ $message }}</small>
    @enderror
</div>
