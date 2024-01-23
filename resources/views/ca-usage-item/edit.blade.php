@extends('layouts.admin')

@section('page_title', 'Edit Item')

@section('admin_content')
<div class="relative overflow-x-auto px-2">
    <form action="{{ route('ca-usage-items.update', [$caUsage->id, $caUsageItem->id]) }}" method="POST">
        @method('PUT')
        @csrf
        @include('ca-usage-item.partials.form', ['item' => $caUsageItem])
        <div class="flex justify-end items-center gap-3">
            <a href="{{ route('ca-usages.edit', $caUsage->id) }}" class="text-blue-600">Cancel</a>
            <button type="submit"
                class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none">
                Submit
            </button>
        </div>
    </form>
</div>
@endsection