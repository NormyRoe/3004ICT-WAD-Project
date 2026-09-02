
@extends('layouts.app')

@section('title')
    {{ $farmName }} Landing Page
@endsection

@section('content')
    <h2 class="text-3xl font-bold text-green-900">Welcome, {{ auth()->user()->first_name }}!</h2>

    <p class="mt-4 text-stone-700">
        Please select a menu option from the menu.
    </p>
@endsection
