@extends('layouts.app')

@section('title')
    Edit an Inventory
@endsection

@section('content')
    <h2 class="text-3xl font-bold text-green-900">Update an existing Inventory Item</h2>

    <!-- Back to Index Button  -->
    <x-back-controller route='inventories.index' label='Back to Inventories Page' />

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
    
    <!-- ========================= -->
    <!-- Update Form -->
    <!-- ========================= -->
    <form action="{{ route('inventories.update', $inventory->id) }}" method="POST" class="mt-6">
        @csrf
        {{ method_field('PUT') }}

        <div class="mb-4">

            <!-- Tree  -->
            <div class="mt-2">
                <h3 class="text-xl font-bold text-green-900 mb-4">Tree:</h3>

                <div class="flex flex-wrap gap-12 mt-2">

                    <!-- Plant Id  -->
                    <div class="flex flex-col space-y-4">
                        <label class="block text-green-900 font-semibold block">Plant ID</label>
                        <label class="text-orange-900 font-semibold block">{{ $inventory->tree->plant_id }}</label>

                    </div>

                    <!-- Common Name  -->
                    <div class="flex flex-col space-y-4">
                        <label class="block text-green-900 font-semibold block">Common Name</label>
                        <label class="text-orange-900 font-semibold block">{{ $inventory->tree->common_name }}</label>

                    </div>
                    
                </div>

            </div>

            <!-- Pot Size  -->
            <div class="mt-4">
                <h3 class="text-xl font-bold text-green-900 mb-4">Pot Size:</h3>
                <label class="text-orange-900 font-semibold block">{{ $inventory->pot_size->size }}</label>

            </div>

            <!-- Location  -->
            <div class="mt-4">

                <h3 class="text-xl font-bold text-green-900 mb-4">Location:</h3>
                <div>
                    <label class="text-red-700 font-semibold">Note: </label>
                    <label class="text-sm text-green-900">The location you select must exist in the locations table</label>
                </div>

                <div class="flex flex-wrap gap-12 mt-2">

                    <!-- Area  -->
                    <div class="flex flex-col space-y-4">
                        <label class="block text-green-900 font-semibold block">Area</label>
                        <select 
                            name="area_id"
                            class="p-2 border border-yellow-800 rounded text-xs md:text-sm"
                            required
                        >
                            <!-- Empty option (deselect filter) -->
                            <option value=""></option>

                            <!-- Distinct values -->
                            @foreach ($areas as $area)
                                <option 
                                    value="{{ $area->id }}"
                                    {{ old('area_id', $inventory->location->area_id) == $area->id ? 'selected' : '' }}
                                >
                                    {{ $area->name }}
                                </option>
                            @endforeach

                        </select>

                    </div>

                    <!-- Block  -->
                    <div class="flex flex-col space-y-4">
                        <label class="block text-green-900 font-semibold block">Block</label>
                        <select 
                            name="block_id"
                            class="p-2 border border-yellow-800 rounded text-xs md:text-sm"
                        >
                            <!-- Empty option (deselect filter) -->
                            <option value=""></option>

                            <!-- Distinct values -->
                            @foreach ($blocks as $block)
                                <option 
                                    value="{{ $block->id }}"
                                    {{ old('block_id', $inventory->location->block_id) == $block->id ? 'selected' : '' }}
                                >
                                    {{ $block->name }}
                                </option>
                            @endforeach

                        </select>

                    </div>

                    <!-- Aisle  -->
                    <div class="flex flex-col space-y-4">
                        <label class="block text-green-900 font-semibold block">Aisle</label>
                        <select 
                            name="aisle_id"
                            class="p-2 border border-yellow-800 rounded text-xs md:text-sm"
                        >
                            <!-- Empty option (deselect filter) -->
                            <option value=""></option>

                            <!-- Distinct values -->
                            @foreach ($aisles as $aisle)
                                <option 
                                    value="{{ $aisle->id }}"
                                    {{ old('aisle_id', $inventory->location->aisle_id) == $aisle->id ? 'selected' : '' }}
                                >
                                    {{ $aisle->name }}
                                </option>
                            @endforeach

                        </select>

                    </div>
                    
                </div>

            </div>

            <!-- Quantity  -->
            <div class="mt-4">
                <h3 class="text-xl font-bold text-green-900 mb-4">Quantity:</h3>
                <input 
                    type="text" 
                    name="quantity" 
                    class="border border-yellow-800 rounded p-2 w-64"
                    value="{{ old('quantity', $inventory->quantity) }}"
                    required
                >
            </div>            
            
        </div>

        <!-- Button  -->
        <div class="flex mt-12 justify-center max-w-xl">
            <x-button-admin type="submit" value="Update Inventory" />
        </div>

    </form>


@endsection
