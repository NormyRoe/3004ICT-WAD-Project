
@extends('layouts.app')

@section('title')
    Profile
@endsection

@section('content')
    <h2 class="text-3xl font-bold text-green-900">Welcome to the Profile page, {{ $name }}</h2>

    <p class="mt-4 text-stone-700">
        Please update your profile.
    </p>
@endsection
