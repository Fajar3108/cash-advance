@extends('layouts.admin')

@section('page_title', 'Edit Reimbursement')

@section('admin_content')
<form action="{{ route('reimbursements.update', $reimbursement->id) }}" method="POST">
    @method('PUT')
    <div class="relative overflow-x-auto px-2">
        <div class="flex items-center gap-4 justify-end mt-3">
            <a href="{{ route('reimbursements.index') }}" class="text-blue-600">Cancel</a>
            <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
        </div>
        @csrf
        @include('cash-advance.partials.form')
    </div>
    <input type="hidden" id="items-hidden-input" name="items" value="">
</form>
<hr>
{{-- <div class="relative overflow-x-auto px-2 mt-5">
    <div class="flex justify-between items-center mb-3">
        <h2 class="text-lg font-bold mb-3">Items</h2>
        <a href="{{ route('items.create', $reimbursement->id) }}"
            class="focus:outline-none text-blue-600 border border-blue-700 hover:text-white hover:bg-blue-600 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg cursor-pointer text-sm py-2 px-4 flex gap-2 items-center">
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 1v16M1 9h16" />
            </svg>
            Tambah
        </a>
    </div>
    @include('item.partials.table', ['items' => $reimbursement->items])
    <div class="w-full flex justify-end py-4">
        <p class="font-bold">
            Total: Rp{{
            number_format(
            $reimbursement->items->sum(function($t){
            return $t->quantity * $t->price;
            }), 0, ',', '.'
            );
            }}
        </p>
    </div>
</div> --}}
@endsection

@section('scripts')
@vite('resources/js/manage-item.js')
@endsection