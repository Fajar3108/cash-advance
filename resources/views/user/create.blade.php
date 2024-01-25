@extends('layouts.admin')

@section('page_title', 'Tambah User')

@section('admin_content')
<div class="relative overflow-x-auto px-2">
    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('user.partials.form')
    </form>
</div>
@endsection
