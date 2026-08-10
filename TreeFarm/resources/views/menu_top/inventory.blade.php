
@extends('layouts.app')

@section('title')
    Inventory
@endsection

@section('content')
    <h2 class="text-3xl font-bold text-green-900">Welcome to the Inventory area, {{ $name }}</h2>

    <p class="mt-4 text-stone-700">
        Here is all of the current inventory.
    </p>
@endsection
