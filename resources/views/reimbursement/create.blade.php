@extends('layouts.admin')

@section('page_title', 'Tambah Reimbursement')

@section('admin_content')
<form action="{{ route('reimbursements.store') }}" method="POST">
    <div class="relative overflow-x-auto px-2">
        <div class="flex items-center gap-4 justify-end mt-3">
            <a href="{{ route('reimbursements.index') }}" class="text-blue-600">Cancel</a>
            <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
        </div>
        @csrf
        @include('reimbursement.partials.form')
    </div>
    <input type="hidden" id="items-hidden-input" name="items" value="">
</form>
<hr>
<div class="relative overflow-x-auto px-2 mt-5">
    <h2 class="text-lg font-bold mb-3">Items</h2>
    @error('items')
    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
        {{ $message }}
    </div>
    @enderror
    <div id="item-form">
        @include('reimbursement-item.partials.form')
    </div>
    <button type="button" id="add-item-button"
        class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-10">
        <svg class="w-4 h-4 text-blue-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 18 18">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 1v16M1 9h16" />
        </svg>
    </button>
    @include('reimbursement-item.partials.table', ['items' => []])
</div>
@endsection

@section('scripts')
@vite('resources/js/manage-reimbursement-item.js')
@endsection