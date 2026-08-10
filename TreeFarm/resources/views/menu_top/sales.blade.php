
@extends('layouts.app')

@section('title')
    Sales
@endsection

@section('content')
    <h2 class="text-3xl font-bold text-green-900">Welcome to the Sales area, {{ $name }}</h2>

    <p class="mt-4 text-stone-700">
        Here are all the company sales.
    </p>
@endsection
