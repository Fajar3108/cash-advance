@extends('layouts.admin')

@section('page_title', 'Detail Reimbursement')

@section('admin_content')

<div class="w-full md:w-1/2 border border-gray-300 rounded-xl">
    <div class="flex justify-between p-4 border-b">
        <p class="font-bold pr-3">Tanggal</p>
        <p>{{ $reimbursement->date }}</p>
    </div>
    <div class="flex justify-between p-4 border-b">
        <p class="font-bold pr-3">Status</p>
        @if ($reimbursement->is_approved)
        <p class="text-green-600 font-bold">Accepted</p>
        @else
        <p class="text-yellow-400 font-bold">Pending</p>
        @endif

    </div>
    <div class="flex justify-between p-4 border-b">
        <p class="font-bold pr-3">Pemohon</p>
        <p>{{ $reimbursement->user->name }}</p>
    </div>
    <div class="flex justify-between p-4 border-b">
        <p class="font-bold">Menyetujui</p>
        <p>{{ $reimbursement->admin->name ?? "-" }}</p>
    </div>
    <div class="flex justify-between p-4 border-b">
        <p class="font-bold pr-3">TTD Digital Pemohon</p>
        @if ($reimbursement->is_user_signature_showed)
        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
            fill="none" viewBox="0 0 20 20">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m7 10 2 2 4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
        @else
        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
            fill="none" viewBox="0 0 20 20">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m13 7-6 6m0-6 6 6m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
        @endif
    </div>
    <div class="flex justify-between p-4 border-b">
        <p class="font-bold pr-3">TTD Digital Menyetujui</p>
        @if ($reimbursement->is_admin_signature_showed)
        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
            fill="none" viewBox="0 0 20 20">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m7 10 2 2 4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
        @else
        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
            fill="none" viewBox="0 0 20 20">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m13 7-6 6m0-6 6 6m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
        @endif
    </div>
    <div class="flex justify-between p-4 border-b">
        <p class="font-bold pr-3">Keterangan</p>
        <p>{!! nl2br($reimbursement->note ?? '-')!!}</p>
    </div>
</div>

<div class="relative overflow-x-auto px-2 mt-5">
    <h2 class="text-lg font-bold mb-3">Items</h2>
    @include('reimbursement-item.partials.table', ['items' => $reimbursement->items])
    <div class="w-full flex justify-end py-4">
        <p class="font-bold">
            Total: Rp{{
            number_format($reimbursement->items->sum('price'), 0, ',', '.');
            }}
        </p>
    </div>
</div>
@endsection
