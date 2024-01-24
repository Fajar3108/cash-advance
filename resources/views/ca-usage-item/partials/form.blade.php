@php
$values = [
'note' => '',
'quantity' => 0,
'amount' => 0,
'type' => 'debit',
'date' => now()->format('Y-m-d')
];

if (isset($item)) {
$values = [
'note' => $item->note,
'quantity' => $item->quantity,
'amount' => $item->amount,
'type' => $item->type,
'date' => $item->date
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
    <label for="amount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Amount</label>
    <div class="flex items-center gap-3">
        <div class="w-40">
            <select name="type" id="type"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                <option value="debit" @if ($values['type']==='debit' ) selected @endif>Debit</option>
                <option value="credit" @if ($values['type']==='credit' ) selected @endif>Kredit</option>
            </select>
        </div>
        <div class="w-full">
            <input type="number" id="amount" name="amount"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required
                value="{{ old('amount') ?? $values['amount'] }}">
            @error('amount')
            <small class="text-red-600">{{ $message }}</small>
            @enderror
        </div>
    </div>
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