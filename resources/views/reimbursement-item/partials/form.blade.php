@php
$values = [
'note' => '',
'quantity' => 0,
'price' => 0,
];

if (isset($item)) {
$values = [
'note' => $item->note,
'quantity' => $item->quantity,
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
    <label for="quantity" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Quantity:</label>
    <div class="relative flex items-center">
        <button type="button" id="decrement-button" data-input-counter-decrement="quantity"
            class="flex-shrink-0 bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 inline-flex items-center justify-center border border-gray-300 rounded-md h-5 w-5 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
            <svg class="w-2.5 h-2.5 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 18 2">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M1 1h16" />
            </svg>
        </button>
        <input type="text" id="quantity" name="quantity" data-input-counter
            class="flex-shrink-0 text-gray-900 dark:text-white border-0 bg-transparent text-sm font-normal focus:outline-none focus:ring-0 max-w-[5rem] text-center"
            value="{{ old('quantity') ?? $values['quantity'] }}" required>
        <button type="button" id="increment-button" data-input-counter-increment="quantity"
            class="flex-shrink-0 bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 inline-flex items-center justify-center border border-gray-300 rounded-md h-5 w-5 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
            <svg class="w-2.5 h-2.5 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 18 18">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 1v16M1 9h16" />
            </svg>
        </button>
    </div>
    @error('quantity')
    <small class="text-red-600">{{ $message }}</small>
    @enderror
</div>
<div class="mb-5">
    <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Harga</label>
    <input type="number" id="price" name="price"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required
        value="{{ old('price') ?? $values['price'] }}">
    @error('price')
    <small class="text-red-600">{{ $message }}</small>
    @enderror
</div>