
@extends('layouts.app')

@section('title')
    Admin
@endsection

@section('content')
    <h2 class="text-3xl font-bold text-green-900">Welcome to the Admin area, {{ $name }}</h2>

    <p class="mt-4 text-stone-700">
        Please select one of the following options.
    </p>
@endsection
