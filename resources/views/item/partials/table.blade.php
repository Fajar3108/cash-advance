<table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th scope="col" class="px-6 py-3">No</th>
            <th scope="col" class="px-6 py-3">
                Keterangan
            </th>
            <th scope="col" class="px-6 py-3">
                QTY
            </th>
            <th scope="col" class="px-6 py-3">
                Harga
            </th>
            <th scope="col" class="px-6 py-3">
                Jumlah
            </th>
            @if (request()->routeIs('cash-advances.edit'))
            <th scope="col" class="px-6 py-3">
                Action
            </th>
            @endif
        </tr>
    </thead>
    <tbody id="items-container">
        @foreach ($items as $item)
        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
            <td class="px-6 py-4">
                {{ $loop->iteration }}
            </td>
            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                {{ $item->note }}
            </td>
            <td class="px-6 py-4">
                {{ $item->quantity }}
            </td>
            <td class="px-6 py-4">
                Rp{{ number_format($item->price) }}
            </td>
            <td class="px-6 py-4">
                Rp{{ number_format($item->quantity * $item->price) }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>