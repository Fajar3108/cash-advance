@extends('layouts.admin')

@section('page_title', 'Edit Pengajuan Barang & ATK')

@section('admin_content')
<form action="{{ route('stuffs.update', $stuff->id) }}" method="POST">
    @method('PUT')
    <div class="relative overflow-x-auto px-2">
        <div class="flex items-center gap-4 justify-end mt-3">
            <a href="{{ route('stuffs.index') }}" class="text-blue-600">Cancel</a>
            <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
        </div>
        @csrf
        @include('stuff.partials.form')
    </div>
    <input type="hidden" id="items-hidden-input" name="items" value="">
</form>
@endsection