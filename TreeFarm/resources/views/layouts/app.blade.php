
@extends('layouts.master')

@section('body')

<div class="flex flex-col md:flex-row">

    <!-- Sidebar -->
    <x-sidebar :name="$name" />

    <!-- Main Content Area -->
    <main class="flex-1 p-6">
        @yield('content')
        
    </main>

</div>

@endsection
