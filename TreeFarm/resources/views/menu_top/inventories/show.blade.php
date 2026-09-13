@extends('layouts.app')

@section('title')
    View an Inventory
@endsection

@section('content')
    <h2 class="text-3xl font-bold text-green-900">View an existing Inventory</h2>

    <!-- Back to Index Button  -->
    <x-back-controller route='inventories.index' label='Back to Inventories Page' />

    <!-- Create/Update Success Message  -->
    @if(session('success'))
        <div class="bg-amber-200 text-orange-900 p-4 rounded mb-4 border border-amber-600 shadow-sm">
            {{ session('success') }}
        </div>
    @endif
    
    <!-- ========================= -->
    <!-- Show Details -->
    <!-- ========================= -->

    <div class="flex flex-col space-y-4 bg-yellow-100 p-6 rounded border border-yellow-800 max-w-xl">

        <!-- Plant ID  -->
        <div>
            <label class="block text-green-900 font-semibold block">Plant ID</label>
            <label class="text-black block">{{ $inventory->tree->plant_id }}</label>
        </div>

        <!-- Tree  -->
        <div>
            <label class="block text-green-900 font-semibold block">Tree</label>
            <label class="text-black block">{{ $inventory->tree->common_name }}</label>
        </div>

        <!-- Pot Size  -->
        <div>
            <label class="block text-green-900 font-semibold block">Pot Size</label>
            <label class="text-black block">{{ $inventory->pot_size->size }}</label>
        </div>

        <!-- Mature Height  -->
        <div>
            <label class="block text-green-900 font-semibold block">Mature Height:</label>

            <div class="flex flex-wrap gap-12 mt-2">

                <div class="flex flex-col space-y-4">
                    <label class="block text-green-900 font-semibold block">Min</label>
                    <label class="text-black block">{{ $inventory->tree->mature_height_min ?? '' }}</label>
                </div>

                <div class="flex flex-col space-y-4">
                    <label class="block text-green-900 font-semibold block">Max</label>
                    <label class="text-black block">{{ $inventory->tree->mature_height_max }}</label>
                </div>
                
            </div>
            
        </div>

            <!-- Mature Width  -->
        <div>
            <label class="block text-green-900 font-semibold block">Mature Width:</label>

            <div class="flex flex-wrap gap-12 mt-2">

                <div class="flex flex-col space-y-4">
                    <label class="block text-green-900 font-semibold block">Min</label>
                    <label class="text-black block">{{ $inventory->tree->mature_width_min ?? '' }}</label>
                </div>

                <div class="flex flex-col space-y-4">
                    <label class="block text-green-900 font-semibold block">Max</label>
                    <label class="text-black block">{{ $inventory->tree->mature_width_max }}</label>
                </div>
                
            </div>
            
        </div>

        <!-- Location  -->
        <div>
            <label class="block text-green-900 font-semibold block">Location:</label>

            <div class="flex flex-wrap gap-12 mt-2">

                <div class="flex flex-col space-y-4">
                    <label class="block text-green-900 font-semibold block">Area</label>
                    <label class="text-black block">{{ $inventory->location->area->name }}</label>
                </div>

                <div class="flex flex-col space-y-4">
                    <label class="block text-green-900 font-semibold block">Block</label>
                    <label class="text-black block">{{ $inventory->location->block?->name ?? '' }}</label>
                </div>

                <div class="flex flex-col space-y-4">
                    <label class="block text-green-900 font-semibold block">Aisle</label>
                    <label class="text-black block">{{ $inventory->location->aisle?->name ?? '' }}</label>
                </div>
                
            </div>
            
        </div>

        <!-- Quantity  -->
        <div>
            <label class="block text-green-900 font-semibold block">Quantity</label>
            <label class="text-black block">{{ $inventory->quantity }}</label>
        </div>
        
        
    </div>

    <!-- ========================= -->
    <!-- Buttons -->
    <!-- ========================= -->
    
    @can('inventory-access')
    
        <div class="flex justify-center gap-24 mt-10 max-w-xl">

            <!-- Update -->
            <a href="{{ route('inventories.edit', $inventory->id) }}">
                <x-button-admin type="button" value="Update" />
            </a>

            <!-- Delete -->
            <a href="{{ route('inventories.delete_confirm', $inventory->id) }}">
                <x-button-admin type="button" value="Delete" />
            </a>

        </div>

    @endcan

@endsection
