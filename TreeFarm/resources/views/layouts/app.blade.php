
@extends('layouts.master')

@section('body')

@auth

    <div class="flex flex-col md:flex-row">

        <!-- Sidebar -->
        <x-sidebar :name="auth()->user()->username" />

        <!-- Main Content Area -->
        <main class="flex-1 p-6">
            @yield('content')
            
        </main>

    </div>

@endauth 

@endsection