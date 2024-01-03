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
            @if (request()->routeIs('cash-advances.edit') || request()->routeIs('cash-advances.create'))
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
            @if (request()->routeIs('cash-advances.edit'))
            <td scope="col" class="px-6 py-3">
                <div class="flex items-center gap-1">
                    <a href="{{ route('items.edit', [request()->cash_advance, $item->id]) }}" type="button"
                        class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg cursor-pointer text-sm px-3 py-2">
                        <svg class="w-4 h-4 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 21 21">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7.418 17.861 1 20l2.139-6.418m4.279 4.279 10.7-10.7a3.027 3.027 0 0 0-2.14-5.165c-.802 0-1.571.319-2.139.886l-10.7 10.7m4.279 4.279-4.279-4.279m2.139 2.14 7.844-7.844m-1.426-2.853 4.279 4.279" />
                        </svg>
                    </a>
                    <form action="{{ route('items.destroy', [request()->cash_advance, $item->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg cursor-pointer text-sm px-3 py-2">
                            <svg class="w-4 h-4 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 18 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M1 5h16M7 8v8m4-8v8M7 1h4a1 1 0 0 1 1 1v3H6V2a1 1 0 0 1 1-1ZM3 5h12v13a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V5Z" />
                            </svg>
                        </button>
                    </form>
                </div>
            </td>
            @endif
        </tr>
        @endforeach
    </tbody>
</table>