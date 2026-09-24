
@extends('layouts.app')

@section('title')
    Reports
@endsection

@section('content')
    <h2 class="text-3xl font-bold text-green-900">Welcome to the Reports area, {{ auth()->user()->first_name }}</h2>

    <p class="mt-4 text-stone-700">
        Currently there is only a Sales Reports section, but more report sections can be added in the future if required.
    </p>

    <!-- Grid Containing the Reference Data options  -->
    <div class="grid grid-cols-2 gap-10 mt-10">

        <!-- Both sub Admin access groups can see this menu option -->
        <a href="{{ route('reports.sales_reports') }}"
           class="bg-amber-600 text-green-900 font-semibold p-6 rounded hover:bg-amber-700 text-center">
            Sales Reports
        </a>



    </div>
    
@endsection
