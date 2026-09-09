@extends('layouts.app')

@section('title')
    Add Exception Price
@endsection

@section('content')
    <h2 class="text-3xl font-bold text-green-900">Add a New Exception Price</h2>

    <!-- Back to Index Button  -->
    <x-back-controller route='prices.index' label='Back to Prices Page' />
    
    <!-- ========================= -->
    <!-- Creation Form -->
    <!-- ========================= -->
    <form action="{{ route('exception_prices.store') }}" method="POST" class="mt-6">
        @csrf

        <div class="mb-4">

            <!-- Tree  -->
            <label class="block text-green-900 font-semibold mb-2">Tree</label>
            <select 
                name="tree_id"
                class="p-2 border border-yellow-800 rounded text-xs md:text-sm"
                required
            >
                <!-- Empty option (deselect filter) -->
                <option value=""></option>

                <!-- Distinct values -->
                @foreach ($trees as $tree)
                    <option 
                        value="{{ $tree->id }}"
                        {{ old('tree_id') == $tree->id ? 'selected' : '' }}
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
                required
            >
                <!-- Empty option (deselect filter) -->
                <option value=""></option>

                <!-- Distinct values -->
                @foreach ($pot_sizes as $pot_size)
                    <option 
                        value="{{ $pot_size->id }}"
                        {{ old('pot_size_id') == $pot_size->id ? 'selected' : '' }}
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
                value="{{ old('price') }}"
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
        <div class="flex mt-12 justify-center max-w-xl">
            <x-button-admin type="submit" value="Add Exception Price" />
        </div>

    </form>

@endsection
