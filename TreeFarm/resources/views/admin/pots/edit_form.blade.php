@extends('layouts.app')

@section('title')
    Edit a Pot Size
@endsection

@section('content')
    <h2 class="text-3xl font-bold text-green-900">Update an existing Pot Size</h2>

    <!-- Back to Index Button  -->
    <x-back-controller route='pot_sizes.index' label='Back to Pots Page' />
    
    <!-- ========================= -->
    <!-- Update Form -->
    <!-- ========================= -->
    <form method="POST" action="{{ route('pot_sizes.update', $pot_size->id) }}" class="mt-6">
        @csrf
        {{ method_field('PUT') }}
        <div class="mb-4">

            <!-- Size Label  -->
            <label class="block text-green-900 font-semibold mb-2">Size</label>

            <!-- Size Input Field  -->
            <input 
                type="text" 
                name="size" 
                class="border border-yellow-800 rounded p-2 w-64"
                value="{{ $pot_size->size }}"
                required
            >
            <!-- Error Message  -->
            @error('size')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Button  -->
        <x-button-admin type="submit" value="Update Pot Size" />

    </form>
@endsection
