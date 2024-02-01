@extends('layouts.admin')

@section('page_title', 'Edit User')

@section('admin_content')
    <div class="relative overflow-x-auto px-2">
        <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            @include('user.partials.form')
        </form>
    </div>
@endsection
