
@extends('layouts.app')

@section('title')
    Tasks
@endsection

@section('content')
    <h2 class="text-3xl font-bold text-green-900">Welcome to the Tasks area, {{ $name }}</h2>

    <p class="mt-4 text-stone-700">
        Here are all of the tasks.
    </p>
@endsection
