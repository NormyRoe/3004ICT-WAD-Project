
@extends('layouts.app')

@section('title')
    Admin
@endsection

@section('content')
    <h2 class="text-3xl font-bold text-green-900">Welcome to the Admin area, {{ $name }}</h2>

    <p class="mt-4 text-stone-700">
        Please select one of the options to see and update the reference data used by this application.
    </p>

    <!-- Grid Containing the Reference Data options  -->
    <div class="grid grid-cols-2 gap-10 mt-10">

        <a href="#"
           class="bg-amber-600 text-green-900 font-semibold p-6 rounded hover:bg-amber-700 text-center">
            Farm Details
        </a>

        <a href="#"
           class="bg-amber-600 text-green-900 font-semibold p-6 rounded hover:bg-amber-700 text-center">
            Pots
        </a>

        <a href="#"
           class="bg-amber-600 text-green-900 font-semibold p-6 rounded hover:bg-amber-700 text-center">
            Trees
        </a>

        <a href="#"
           class="bg-amber-600 text-green-900 font-semibold p-6 rounded hover:bg-amber-700 text-center">
            Tree Locations
        </a>

        <a href="#"
           class="bg-amber-600 text-green-900 font-semibold p-6 rounded hover:bg-amber-700 text-center">
            Prices
        </a>

        <a href="#"
           class="bg-amber-600 text-green-900 font-semibold p-6 rounded hover:bg-amber-700 text-center">
            Task Types
        </a>

        <a href="#"
           class="bg-amber-600 text-green-900 font-semibold p-6 rounded hover:bg-amber-700 text-center">
            Users and Roles
        </a>
        
    </div>
@endsection
