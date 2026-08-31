@extends('layouts.app')

@section('title')
    Add Pot Size
@endsection

@section('content')
    <h2 class="text-3xl font-bold text-green-900">Add a New Pot Size</h2>

    <!-- Back to Index Button  -->
    <x-back-controller route='pot_sizes.index' label='Back to Pots Page' />
    
    <!-- ========================= -->
    <!-- Creation Form -->
    <!-- ========================= -->
    <form action="{{ route('pot_sizes.store') }}" method="POST" class="mt-6">
        @csrf

        <div class="mb-4">

            <!-- Size Label  -->
            <label class="block text-green-900 font-semibold mb-2">Size</label>

            <!-- Size Input Field  -->
            <input 
                type="text" 
                name="size" 
                class="border border-yellow-800 rounded p-2 w-64"
                value="{{ old('size') }}"
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
        <x-button-admin type="submit" value="Add Pot Size" />

    </form>
@endsection
