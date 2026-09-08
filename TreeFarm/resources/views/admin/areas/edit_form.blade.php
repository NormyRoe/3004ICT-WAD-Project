@extends('layouts.app')

@section('title')
    Edit an Area
@endsection

@section('content')
    <h2 class="text-3xl font-bold text-green-900">Update an existing Area</h2>

    <!-- Back to Index Button  -->
    <x-back-controller route='locations.index' label='Back to Locations Page' />
    
    <!-- ========================= -->
    <!-- Update Form -->
    <!-- ========================= -->
    <form method="POST" action="{{ route('areas.update', $area->id) }}" class="mt-6">
        @csrf
        {{ method_field('PUT') }}
        <div class="mb-4">

            <!-- Area Label  -->
            <label class="block text-green-900 font-semibold mb-2">Area</label>

            <!-- Area Input Field  -->
            <input 
                type="text" 
                name="area" 
                class="border border-yellow-800 rounded p-2 w-64"
                value="{{ old('area', $area->name) }}"
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
        <x-button-admin type="submit" value="Update Area" />

    </form>
@endsection
