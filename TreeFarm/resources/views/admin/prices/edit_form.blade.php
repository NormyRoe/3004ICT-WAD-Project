@extends('layouts.app')

@section('title')
    Edit a Price
@endsection

@section('content')
    <h2 class="text-3xl font-bold text-green-900">Update an existing Price</h2>

    <!-- Back to Index Button  -->
    <x-back-controller route='prices.index' label='Back to Prices Page' />
    
    <!-- ========================= -->
    <!-- Update Form -->
    <!-- ========================= -->
    <form method="POST" action="{{ route('prices.update', $price->id) }}" class="mt-6">
        @csrf
        {{ method_field('PUT') }}
        <div class="mb-4">

            <!-- Name  -->
            <label class="block text-green-900 font-semibold mb-2">Name</label>
            <input 
                type="text" 
                name="name" 
                class="border border-yellow-800 rounded p-2 w-64"
                value="{{ old('name', $price->name) }}"
            >

            <!-- Pot Size  -->
            <label class="block text-green-900 font-semibold mb-2">Pot Size</label>
            <select 
                name="pot_size_id"
                class="p-2 border border-yellow-800 rounded text-xs md:text-sm"
            >

                <!-- Empty option -->
                <option value=""></option>
                
                <!-- Distinct values -->
                @foreach ($pot_sizes as $pot_size)
                    <option 
                        value="{{ $pot_size->id }}"
                        {{ old('pot_size_id', $price->pot_size_id) == $pot_size->id ? 'selected' : '' }}
                    >
                        {{ $pot_size->size }}
                    </option>
                @endforeach

            </select>

            <!-- Price  -->
            <label class="block text-green-900 font-semibold mb-2">Price ($)</label>
            <input 
                type="text" 
                name="price" 
                class="border border-yellow-800 rounded p-2 w-64"
                value="{{ old('price', $price->price) }}"
            >

            <!-- Rate  -->
            <label class="block text-green-900 font-semibold mb-2">Rate (%)</label>
            <input 
                type="text" 
                name="rate" 
                class="border border-yellow-800 rounded p-2 w-64"
                value="{{ old('rate', $price->rate) }}"
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
        <x-button-admin type="submit" value="Update Price" />

    </form>

@endsection
