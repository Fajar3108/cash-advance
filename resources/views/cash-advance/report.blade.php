@extends('layouts.admin')

@section('page_title', 'Laporan Pengajuan CA')

@section('admin_content')
<div class="relative overflow-x-auto pb-10">
    <div class="flex items-center justify-center flex-col md:flex-row gap-2 mb-3">
        <form class="w-full">
            <label for="default-search"
                class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input name="q" type="text" id="default-search"
                    class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white outline-none"
                    placeholder="Search..." required>
                <button type="submit"
                    class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
            </div>
        </form>
    </div>
    @if (request()->query('q'))
    <div class="flex items-center justify-between mb-3">
        <div class="text-sm">
            Hasil pencarian untuk "{{ request()->query('q') }}"
            <a href="{{ route('cash-advances.report') }}" class="text-sm text-blue-400">
                [ Clear Search ]
            </a>
        </div>
    </div>
    @endif
    <div class="grid grid-cols-3 gap-3 mb-3">
        <div>
            <label for="start_date" class="text-sm font-medium text-gray-900 dark:text-white">From</label>
            <input name="start_date" type="date" id="start_date"
                class="block w-full p-4 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white outline-none"
                required value="{{ request()->startDate ?? now()->format('Y-m-d') }}">
        </div>
        <div>
            <label for="end_date" class="text-sm font-medium text-gray-900 dark:text-white">To</label>
            <input name="end_date" type="date" id="end_date"
                class="block w-full p-4 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white outline-none"
                required value="{{ request()->endDate ?? now()->format('Y-m-d') }}">
        </div>
        <div>
            <label for="request_by" class="text-sm font-medium text-gray-900 dark:text-white">Pemohon</label>
            <select name="request_by" type="date" id="request_by"
                class="block w-full p-4 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white outline-none"
                required>
                <option value="">Semua Pemohon</option>
                @foreach (App\Models\User::orderBy('name')->get() as $user)
                <option value="{{ $user->id }}" {{ request()->requestBy === $user->id ? 'selected' : '' }}>{{
                    $user->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Pemohon
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Tanggal
                    </th>
                    <th scope="col" class="px-6 py-3">No</th>
                    <th scope="col" class="px-6 py-3">
                        Nama CA
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Status
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cashAdvances as $cashAdvance)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="px-6 py-4">
                        {{ $cashAdvance->user->name }}
                    </td>
                    <td class="px-6 py-4">
                        {{ Carbon\Carbon::parse($cashAdvance->date)->format('d/m/Y') }}
                    </td>
                    <td class="px-6 py-4">
                        {{ str_pad($cashAdvance->no, 3, '0', STR_PAD_LEFT) }}/CA/IT/{{
                        $cashAdvance->created_at->format('Y') }}
                    </td>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ str()->limit($cashAdvance->name, 20) }}
                    </th>
                    <td class="px-6 py-4">
                        @if (!$cashAdvance->is_approved)
                        <p class="text-yellow-400 font-bold">Pending</p>
                        @else
                        <p class="text-green-600 font-bold">Approved</p>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const requestByElement = document.getElementById('request_by');
    const startDateElement = document.getElementById('start_date');
    const endDateElement = document.getElementById('end_date');

    const setUrlParams = (key, value) => {
        const url = new URL(window.location.href);
        const params = new URLSearchParams(url.search);

        if (value !== '') {
            params.set(key, value);
        } else {
            params.delete(key);
        }

        history.replaceState(null, null, '?' + params.toString());

        window.location.reload();
    }

    requestByElement.addEventListener('change', () => setUrlParams('requestBy', requestByElement.value));
    startDateElement.addEventListener('change', () => setUrlParams('startDate', startDateElement.value));
    endDateElement.addEventListener('change', () => setUrlParams('endDate', endDateElement.value));
</script>
@endsection