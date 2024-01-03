@extends('layouts.admin')

@section('page_title', 'Edit CA')

@section('admin_content')
<form action="{{ route('cash-advances.update', $cashAdvance->id) }}" method="POST">
    @method('PUT')
    <div class="relative overflow-x-auto px-2">
        <div class="flex items-center gap-4 justify-end mt-3">
            <a href="{{ route('cash-advances.index') }}" class="text-blue-600">Cancel</a>
            <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
        </div>
        @csrf
        @include('cash-advance.partials.form')
    </div>
    <input type="hidden" id="items-hidden-input" name="items" value="">
</form>
<hr>
<div class="relative overflow-x-auto px-2 mt-5">
    <h2 class="text-lg font-bold mb-3">Items</h2>
    @include('item.partials.table', ['items' => $cashAdvance->items])
    <div class="w-full flex justify-end py-4">
        <p class="font-bold">
            Total: Rp{{
            number_format(
            $cashAdvance->items->sum(function($t){
            return $t->quantity * $t->price;
            })
            );
            }}
        </p>
    </div>
</div>
@endsection

@section('scripts')
@vite('resources/js/manage-item.js')
@endsection