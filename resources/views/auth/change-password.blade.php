@extends('layouts.admin')

@section('page_title', 'Change Password')

@section('admin_content')
<div class="relative overflow-x-auto px-2">
    <form action="{{ route('change-password.update') }}" method="POST" enctype="multipart/form-data">
        @method('PATCH')
        @csrf
        <div class="mb-5">
            <label for="current_password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Old
                Password</label>
            <input type="password" id="current_password" name="current_password"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            @error('current_password')
            <small class="text-red-600">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-5">
            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">New
                Password</label>
            <input type="password" id="password" name="password"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            @error('password')
            <small class="text-red-600">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-5">
            <label for="password_confirmation"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirm
                Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            @error('password_confirmation')
            <small class="text-red-600">{{ $message }}</small>
            @enderror
        </div>
        <div class="flex items-center gap-4 justify-end">
            <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Save</button>
        </div>
    </form>
</div>
@endsection