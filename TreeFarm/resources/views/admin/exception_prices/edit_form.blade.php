@extends('layouts.app')

@section('title')
    Edit an Exception Price
@endsection

@section('content')
    <h2 class="text-3xl font-bold text-green-900">Update an existing Exception Price</h2>

    <!-- Back to Index Button  -->
    <x-back-controller route='prices.index' label='Back to Prices Page' />
    
    <!-- ========================= -->
    <!-- Update Form -->
    <!-- ========================= -->
    <form method="POST" action="{{ route('exception_prices.update', $exception_price->id) }}" class="mt-6">
        @csrf
        {{ method_field('PUT') }}
        <div class="mb-4">

            <!-- Tree  -->
            <label class="block text-green-900 font-semibold mb-2">Tree</label>
            <select 
                name="tree_id"
                class="p-2 border border-yellow-800 rounded text-xs md:text-sm"
                required
            >

                <!-- Distinct values -->
                @foreach ($trees as $tree)
                    <option 
                        value="{{ $tree->id }}"
                        {{ old('tree_id', $exception_price->tree_id) == $tree->id ? 'selected' : '' }}
                    >
                        {{ $tree->common_name }}
                    </option>
                @endforeach

            </select>

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
                        {{ old('pot_size_id', $exception_price->pot_size_id) == $pot_size->id ? 'selected' : '' }}
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
                value="{{ old('price', $exception_price->price) }}"
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
        <x-button-admin type="submit" value="Update Exception Price" />

    </form>

@endsection
