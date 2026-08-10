
@extends('layouts.app')

@section('title')
    Users and Roles
@endsection

@section('content')
    <h2 class="text-3xl font-bold text-green-900">Welcome to the Users and Roles reference data, {{ $name }}</h2>

    <!-- Back to Admin Menu Button  -->
    <x-back-admin />

    <!-- Placeholder page text  -->
    <p class="mt-4 text-stone-700">
        Here is the reference data:
    </p>
    
@endsection
