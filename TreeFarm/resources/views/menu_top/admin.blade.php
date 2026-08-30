
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

        <a href="{{ route('farm_details.index') }}"
           class="bg-amber-600 text-green-900 font-semibold p-6 rounded hover:bg-amber-700 text-center">
            Farm Details
        </a>

        <a href="{{ route('pot_sizes.index') }}"
           class="bg-amber-600 text-green-900 font-semibold p-6 rounded hover:bg-amber-700 text-center">
            Pots
        </a>

        <a href="{{ route('trees.index') }}"
           class="bg-amber-600 text-green-900 font-semibold p-6 rounded hover:bg-amber-700 text-center">
            Trees
        </a>

        <a href="{{ route('admin.locations') }}"
           class="bg-amber-600 text-green-900 font-semibold p-6 rounded hover:bg-amber-700 text-center">
            Tree Locations
        </a>

        <a href="{{ route('admin.prices') }}"
           class="bg-amber-600 text-green-900 font-semibold p-6 rounded hover:bg-amber-700 text-center">
            Prices
        </a>

        <a href="{{ route('admin.tasks') }}"
           class="bg-amber-600 text-green-900 font-semibold p-6 rounded hover:bg-amber-700 text-center">
            Task Types
        </a>

        <a href="{{ route('admin.users') }}"
           class="bg-amber-600 text-green-900 font-semibold p-6 rounded hover:bg-amber-700 text-center">
            Users
        </a>

    </div>
@endsection
