<div class="mb-5">
    <label for="cash_advance_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih CA <small
            class="text-gray-400">[Optional]</small></label>
    <select type="text" id="cash_advance_id" name="cash_advance_id"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
        value="{{ old('cash_advance_id') ?? $caUsage->cash_advance_id }}">
        <option value="">--- Pilih CA ---</option>
        @foreach ($cashAdvances as $cashAdvance)
        <option value="{{ $cashAdvance->id }}" {{ $cashAdvance->id == $caUsage->cash_advance_id ? 'selected' : '' }}>
            {{ $cashAdvance->name }}
        </option>
        @endforeach
    </select>
    @error('cash_advance_id')
    <small class="text-red-600">{{ $message }}</small>
    @enderror
</div>

<div class="mb-5">
    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama CA</label>
    <input type="text" id="name" name="name"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required
        value="{{ old('name') ?? $caUsage->name }}">
    @error('name')
    <small class="text-red-600">{{ $message }}</small>
    @enderror
</div>

<div class="mb-5">
    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal</label>
    <input type="date" id="date" name="date"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required
        value="{{ old('date') ?? $caUsage->date }}">
    @error('date')
    <small class="text-red-600">{{ $message }}</small>
    @enderror
</div>

<div class="flex items-center mb-4">
    <input @if ($caUsage->is_user_signature_showed) checked @endif id="is_user_signature_showed"
    name="is_user_signature_showed" type="checkbox"
    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600
    dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
    <label for="is_user_signature_showed" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
        Tampilkan tanda tangan digital Pemohon
    </label>
    @error('is_user_signature_showed')
    <small class="text-red-600">{{ $message }}</small>
    @enderror
</div>