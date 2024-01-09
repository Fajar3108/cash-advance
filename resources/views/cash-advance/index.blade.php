@extends('layouts.admin')

@section('page_title', 'Pengajuan Dana')

@section('admin_content')
<div class="relative overflow-x-auto">
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
                <input name="q" type="search" id="default-search"
                    class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white outline-none"
                    placeholder="Search..." required>
                <button type="submit"
                    class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
            </div>
        </form>
        <a href="{{ route('cash-advances.create') }}"
            class="w-full md:w-auto justify-center focus:outline-none text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg cursor-pointer text-sm p-4 flex gap-2 items-center">
            <svg class="w-3 h-3 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 18 18">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 1v16M1 9h16" />
            </svg>
            Tambah
        </a>
    </div>
    @if (request()->query('q'))
    <div class="flex items-center justify-between mb-3">
        <div class="text-sm text-gray-500">
            Hasil pencarian untuk "{{ request()->query('q') }}"
        </div>
        <a href="{{ route('cash-advances.index') }}"
            class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">Clear
            Search</a>
    </div>
    @endif
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">No</th>
                    <th scope="col" class="px-6 py-3">
                        Nama CA
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Pemohon
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Penyetuju
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Keterangan
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cashAdvances as $cashAdvance)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="px-6 py-4">
                        {{ $loop->iteration }}
                    </td>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $cashAdvance->name }}
                    </th>
                    <td class="px-6 py-4">
                        {{ $cashAdvance->user->name }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $cashAdvance->admin->name ?? "-" }}
                    </td>
                    <td class="px-6 py-4">
                        @if (!$cashAdvance->is_approved && auth()->user()->role_id ==
                        Database\Seeders\RoleSeeder::ADMIN_ID)
                        <button data-modal-target="approve-modal-{{ $cashAdvance->id }}"
                            data-modal-toggle="approve-modal-{{ $cashAdvance->id }}" type="button"
                            class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center flex items-center gap-2">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 16 12">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5" />
                            </svg>
                            Approve
                        </button>
                        <div id="approve-modal-{{ $cashAdvance->id }}" tabindex="-1"
                            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative p-4 w-full max-w-md max-h-full">
                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                    <button type="button"
                                        class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                        data-modal-hide="approve-modal-{{ $cashAdvance->id }}">
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                    <div class="p-4 md:p-5 text-center">
                                        <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200"
                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>
                                        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                                            Are you sure?
                                        </h3>
                                        <form action="{{ route('cash-advances.approve', $cashAdvance->id) }}"
                                            method="POST">
                                            @method('PATCH')
                                            @csrf
                                            <div class="w-full flex justify-center items-center mb-4">
                                                <input checked id="is_admin_signature_showed"
                                                    name="is_admin_signature_showed" type="checkbox"
                                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded
                                                                                focus:ring-blue-500 dark:focus:ring-blue-600
                                                                                dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                <label for="is_admin_signature_showed"
                                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                    Tampilkan tanda tangan digital Penyetuju
                                                </label>
                                            </div>
                                            <div class="flex items-center gap-1 justify-center">
                                                <button type="submit"
                                                    class="text-white bg-green-600 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center me-2 gap-2">
                                                    <svg class="w-3 h-3" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 16 12">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="M1 5.917 5.724 10.5 15 1.5" />
                                                    </svg>
                                                    Yes, I'm sure
                                                </button>
                                                <button data-modal-hide="approve-modal-{{ $cashAdvance->id }}"
                                                    type="button"
                                                    class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">No,
                                                    cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @elseif (!$cashAdvance->is_approved)
                        <p class="text-yellow-400 font-bold">Pending</p>
                        @else
                        <p class="text-green-600 font-bold">Approved</p>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if ($cashAdvance->is_approved && $cashAdvance->note)
                        <div class="flex gap-1 items-center">
                            <button data-modal-target="note-modal-{{ $cashAdvance->id }}"
                                data-modal-toggle="note-modal-{{ $cashAdvance->id }}"
                                class="flex gap-3 items-center text-black font-medium" type="button">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 21 21">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M7.418 17.861 1 20l2.139-6.418m4.279 4.279 10.7-10.7a3.027 3.027 0 0 0-2.14-5.165c-.802 0-1.571.319-2.139.886l-10.7 10.7m4.279 4.279-4.279-4.279m2.139 2.14 7.844-7.844m-1.426-2.853 4.279 4.279" />
                                </svg>
                            </button>
                            {{ $cashAdvance->note }}
                        </div>

                        @elseif ($cashAdvance->is_approved)
                        <button data-modal-target="note-modal-{{ $cashAdvance->id }}"
                            data-modal-toggle="note-modal-{{ $cashAdvance->id }}"
                            class="flex gap-3 items-center text-black border border-black focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2.5 text-center"
                            type="button">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 20 18">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M5 5h9M5 9h5m8-8H2a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h4l3.5 4 3.5-4h5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1Z" />
                            </svg>
                        </button>
                        @else
                        <svg data-tooltip-target="forbidden-note-{{ $cashAdvance->id }}"
                            class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11.5 8V4.5a3.5 3.5 0 1 0-7 0V8M8 12v3M2 8h12a1 1 0 0 1 1 1v9a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1Z" />
                        </svg>
                        <div id="forbidden-note-{{ $cashAdvance->id }}" role="tooltip"
                            class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                            Tidak dapat menambahkan keterangan karena belum disetujui
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>
                        @endif
                        <div id="note-modal-{{ $cashAdvance->id }}" tabindex="-1" aria-hidden="true"
                            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative p-4 w-full max-w-2xl max-h-full">
                                <!-- Modal content -->
                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                    <!-- Modal header -->
                                    <div
                                        class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                            Keterangan
                                        </h3>
                                        <button type="button"
                                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                            data-modal-hide="note-modal-{{ $cashAdvance->id }}">
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                    </div>
                                    <!-- Modal body -->
                                    <div class="p-4 md:p-5">
                                        <form class="space-y-4"
                                            action="{{ route('cash-advances.note', $cashAdvance->id) }}" method="POST">
                                            @method('PATCH')
                                            @csrf
                                            <div>
                                                <textarea id="note" rows="4" name="note"
                                                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300"
                                                    required
                                                    placeholder="Tulis keterangan di sini...">{{ $cashAdvance->note }}</textarea>
                                            </div>
                                            <button type="submit"
                                                class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <button data-popover-target="action-{{ $cashAdvance->id }}" data-popover-placement="left"
                            type="button"
                            class="text-white me-4 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 16 3">
                                <path
                                    d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z" />
                            </svg>
                        </button>
                        <div data-popover id="action-{{ $cashAdvance->id }}" role="tooltip"
                            class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                            <div
                                class="px-3 py-2 bg-gray-100 border-b border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-gray-700">
                                <h3 class="font-semibold text-gray-900 dark:text-white">Action</h3>
                            </div>
                            <ul class="text-left text-gray-500 dark:text-gray-400">
                                <li class="hover:bg-[rgba(0,0,0,.2)]">
                                    <a href="{{ route('cash-advances.show', $cashAdvance->id) }}"
                                        class="p-3 flex gap-3 items-center">
                                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 20 14">
                                            <g stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2">
                                                <path d="M10 10a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                                <path
                                                    d="M10 13c4.97 0 9-2.686 9-6s-4.03-6-9-6-9 2.686-9 6 4.03 6 9 6Z" />
                                            </g>
                                        </svg>
                                        Detail CA
                                    </a>
                                </li>
                                <li class="hover:bg-[rgba(0,0,0,.2)]">
                                    <a href="{{ route('attachments.index', $cashAdvance->id) }}"
                                        class="p-3 flex gap-3 items-center">
                                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M10 18a.969.969 0 0 1-.933 1H1.933A.97.97 0 0 1 1 18V9l4-4m-4 5h5m3-4h5V1m5 1v12a.97.97 0 0 1-.933 1H9.933A.97.97 0 0 1 9 14V5l4-4h5.067A.97.97 0 0 1 19 2Z" />
                                        </svg>
                                        Lampiran
                                    </a>
                                </li>
                                <li class="hover:bg-[rgba(0,0,0,.2)]">
                                    @if ($cashAdvance->is_approved)
                                    <a href="{{ route('cash-advances.pdf', $cashAdvance->id) }}" type="button"
                                        class="p-3 flex gap-3 items-center">
                                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 16 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M1 18a.969.969 0 0 0 .933 1h12.134A.97.97 0 0 0 15 18M1 7V5.828a2 2 0 0 1 .586-1.414l2.828-2.828A2 2 0 0 1 5.828 1h8.239A.97.97 0 0 1 15 2v5M6 1v4a1 1 0 0 1-1 1H1m0 9v-5h1.5a1.5 1.5 0 1 1 0 3H1m12 2v-5h2m-2 3h2m-8-3v5h1.375A1.626 1.626 0 0 0 10 13.375v-1.75A1.626 1.626 0 0 0 8.375 10H7Z" />
                                        </svg>
                                        Print PDF
                                    </a>
                                    @else
                                    <a href="{{ route('cash-advances.edit', $cashAdvance->id) }}" type="button"
                                        class="p-3 flex gap-3 items-center">
                                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 21 21">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M7.418 17.861 1 20l2.139-6.418m4.279 4.279 10.7-10.7a3.027 3.027 0 0 0-2.14-5.165c-.802 0-1.571.319-2.139.886l-10.7 10.7m4.279 4.279-4.279-4.279m2.139 2.14 7.844-7.844m-1.426-2.853 4.279 4.279" />
                                        </svg>
                                        Edit
                                    </a>
                                    @endif
                                </li>
                                <li class="hover:bg-[rgba(0,0,0,.2)]">
                                    @if (
                                    !$cashAdvance->is_approved
                                    || auth()->user()->role_id == Database\Seeders\RoleSeeder::ADMIN_ID
                                    )
                                    <form action="{{ route('cash-advances.destroy', $cashAdvance->id) }}" method="POST"
                                        data-confirmation="true">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="p-3 flex gap-3 items-center w-full text-red-600">
                                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 18 20">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M1 5h16M7 8v8m4-8v8M7 1h4a1 1 0 0 1 1 1v3H6V2a1 1 0 0 1 1-1ZM3 5h12v13a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V5Z" />
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                    @endif
                                </li>
                            </ul>
                            <div data-popper-arrow></div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if ($cashAdvances->hasPages())
    <nav class="flex items-center justify-between mt-4">
        <div class="text-gray-500">
            Showing {{ $cashAdvances->firstItem() }} to {{ $cashAdvances->lastItem() }} of {{ $cashAdvances->total() }}
            results
        </div>
        <div class="flex -space-x-1">
            @if ($cashAdvances->currentPage() > 1)
            <a href="{{ $cashAdvances->previousPageUrl() }}" class="px-4 py-2 rounded-md hover:bg-gray-100">Previous</a>
            @endif
            @php
            $totalPages = $cashAdvances->lastPage() >= 10 ? 10 : $cashAdvances->lastPage();
            @endphp
            @for ($i = 1; $i <= $totalPages; $i++) @if ($i==$cashAdvances->currentPage())
                <span class="px-4 py-2 text-gray-700 bg-gray-100 rounded-md">{{ $i }}</span>
                @else
                <a href="{{ $cashAdvances->appends(['q' => request()->query('q'), 'other' => request()->query('other')])->url($i) }}"
                    class="px-4 py-2 rounded-md hover:bg-gray-100">{{ $i }}</a>
                @endif
                @endfor
                @if ($cashAdvances->currentPage() < $cashAdvances->lastPage())
                    <a href="{{ $cashAdvances->nextPageUrl() }}" class="px-4 py-2 rounded-md hover:bg-gray-100">Next</a>
                    @endif
        </div>
    </nav>
    @endif
</div>
@endsection
