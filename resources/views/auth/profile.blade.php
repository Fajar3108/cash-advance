@extends('layouts.admin')

@section('page_title', 'Profile')

@section('admin_content')
<div class="relative overflow-x-auto px-2">
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @method('PATCH')
        @csrf
        <div class="mb-5">
            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
            <input type="text" id="name" name="name"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required
                value="{{ old('name') ?? auth()->user()->name }}">
            @error('name')
            <small class="text-red-600">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-5">
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
            <input type="email" id="email" name="email"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required
                value="{{ old('email') ?? auth()->user()->email }}">
            @error('email')
            <small class="text-red-600">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-5">
            <label for="department" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jabatan</label>
            <input type="text" id="department" name="department"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required
                value="{{ old('department') ?? auth()->user()->department }}">
            @error('department')
            <small class="text-red-600">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-5">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="signature">Tanda Tangan
                Digital</label>
            <input
                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                aria-describedby="signature_help" id="signature" name="signature" type="file">
            <div class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="signature_help">* (Optional) Kosongkan jika
                tidak
                ingin diubah</div>
            @error('signature')
            <small class="text-red-600">{{ $message }}</small>
            @enderror
        </div>
        <div>
            <img src="{{ asset('storage/' . auth()->user()->signature) }}" alt="Signature"
                class="w-24 h-24 object-contain">
        </div>
        <div class="flex items-center gap-4 justify-end">
            <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Save</button>
        </div>
    </form>
</div>
@endsection
