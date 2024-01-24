<div class="relative overflow-x-auto">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">No</th>
                <th scope="col" class="px-6 py-3">
                    Tanggal
                </th>
                <th scope="col" class="px-6 py-3">
                    Keterangan
                </th>
                <th scope="col" class="px-6 py-3 text-center">
                    D
                </th>
                <th scope="col" class="px-6 py-3 text-center">
                    K
                </th>
                @if (request()->routeIs('ca-usages.edit') || request()->routeIs('ca-usages.create'))
                <th scope="col" class="px-6 py-3">
                    Action
                </th>
                @endif
            </tr>
        </thead>
        <tbody id="items-container">
            @foreach ($items->where('type', 'credit') as $item)
            @include('ca-usage-item.partials.item-row')
            @endforeach
            @foreach ($items->where('type', 'debit') as $item)
            @include('ca-usage-item.partials.item-row')
            @endforeach
        </tbody>
        @if (request()->routeIs('ca-usages.edit') || request()->routeIs('ca-usages.show'))
        <tfoot>
            <tr class="border text-xs text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <th colspan="3" class="py-4 font-bold text-center text-gray-900 whitespace-nowrap dark:text-white">
                    Total
                </th>
                <td class="px-6 py-4 text-center border">
                    Rp{{ number_format($items->where('type', 'debit')->sum('amount'), 0, ',', '.') }}
                </td>
                <td class="px-6 py-4 text-center border">
                    Rp{{ number_format($items->where('type', 'credit')->sum('amount'), 0, ',', '.') }}
                </td>
            </tr>
            <tr class="border text-xs text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <th colspan="3" class="py-4 font-bold text-center text-gray-900 whitespace-nowrap dark:text-white">
                    Sisa Saldo
                </th>
                <td colspan="2" class="border px-6 py-4 text-center font-bold">
                    @php
                    $remaining = $items->where('type', 'credit')->sum('amount') - $items->where('type',
                    'debit')->sum('amount');
                    @endphp

                    @if ($remaining < 0) <span class="text-red-600">
                        -Rp{{ number_format($remaining * -1, 0, ',', '.') }}
                        </span>
                        @else
                        <span class="text-green-600">
                            Rp{{ number_format($remaining, 0, ',', '.') }}
                        </span>
                        @endif
                </td>
            </tr>
        </tfoot>
        @endif
    </table>
</div>