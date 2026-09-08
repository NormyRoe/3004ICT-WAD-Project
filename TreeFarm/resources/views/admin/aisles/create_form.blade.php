@extends('layouts.app')

@section('title')
    Add Aisle
@endsection

@section('content')
    <h2 class="text-3xl font-bold text-green-900">Add a New Aisle</h2>

    <!-- Back to Index Button  -->
    <x-back-controller route='locations.index' label='Back to Locations Page' />
    
    <!-- ========================= -->
    <!-- Creation Form -->
    <!-- ========================= -->
    <form action="{{ route('aisles.store') }}" method="POST" class="mt-6">
        @csrf

        <div class="mb-4">

            <!-- Aisle Label  -->
            <label class="block text-green-900 font-semibold mb-2">Aisle</label>

            <!-- Aisle Input Field  -->
            <input 
                type="text" 
                name="aisle" 
                class="border border-yellow-800 rounded p-2 w-64"
                value="{{ old('aisle') }}"
                required
            >

            <!-- Error Message  -->
            @if (count($errors) > 0)
                <div class="text-red-600 text-sm mt-1">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
        </div>

        <!-- Button  -->
        <x-button-admin type="submit" value="Add Aisle" />

    </form>
@endsection
