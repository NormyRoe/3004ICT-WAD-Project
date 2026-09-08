@extends('layouts.app')

@section('title')
    Edit a Location
@endsection

@section('content')
    <h2 class="text-3xl font-bold text-green-900">Update an existing Location</h2>

    <!-- Back to Index Button  -->
    <x-back-controller route='locations.index' label='Back to Locations Page' />
    
    <!-- ========================= -->
    <!-- Update Form -->
    <!-- ========================= -->
    <form method="POST" action="{{ route('locations.update', $location->id) }}" class="mt-6">
        @csrf
        {{ method_field('PUT') }}
        <div class="mb-4">

            <!-- Area  -->
            <label class="block text-green-900 font-semibold mb-2">Area</label>
            <select 
                name="area_id"
                class="p-2 border border-yellow-800 rounded text-xs md:text-sm"
                required
            >

                <!-- Distinct values -->
                @foreach ($areas as $area)
                    <option 
                        value="{{ $area->id }}"
                        {{ old('area_id', $location->area_id) == $area->id ? 'selected' : '' }}
                    >
                        {{ $area->name }}
                    </option>
                @endforeach

            </select>

            <!-- Block  -->
            <label class="block text-green-900 font-semibold mb-2">Block</label>
            <select 
                name="block_id"
                class="p-2 border border-yellow-800 rounded text-xs md:text-sm"
            >

                <!-- Empty option -->
                <option value=""></option>

                <!-- Distinct values -->
                @foreach ($blocks as $block)
                    <option 
                        value="{{ $block->id }}"
                        {{ old('block_id', $location->block_id) == $block->id ? 'selected' : '' }}
                    >
                        {{ $block->name }}
                    </option>
                @endforeach

            </select>

            <!-- Aisle  -->
            <label class="block text-green-900 font-semibold mb-2">Aisle</label>
            <select 
                name="aisle_id"
                class="p-2 border border-yellow-800 rounded text-xs md:text-sm"
            >

                <!-- Empty option -->
                <option value=""></option>

                <!-- Distinct values -->
                @foreach ($aisles as $aisle)
                    <option 
                        value="{{ $aisle->id }}"
                        {{ old('aisle_id', $location->aisle_id) == $aisle->id ? 'selected' : '' }}
                    >
                        {{ $aisle->name }}
                    </option>
                @endforeach

            </select>



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
        <x-button-admin type="submit" value="Update Location" />

    </form>

@endsection
