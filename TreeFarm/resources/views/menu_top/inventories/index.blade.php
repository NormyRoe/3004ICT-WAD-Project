
@extends('layouts.app')

@section('title')
    Inventory
@endsection

@section('content')

    <h2 class="text-3xl font-bold text-green-900">Welcome to the Inventory area, {{ auth()->user()->first_name }}</h2>

    <!-- Page text  -->
    <p class="mt-4 text-stone-700">
        Here is all of the current inventory:
    </p>

    <!-- Update Success Message  -->
    @if(session('success'))
        <div class="bg-amber-200 text-orange-900 p-4 rounded mb-4 mt-4 border border-amber-600 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- ========================= -->
    <!-- Inventory (Filtering Table with Total) -->
    <!-- ========================= -->

    <!-- Label and Buttons -->
    <div class="flex justify-between items-center mt-10">
        <h3 class="text-2xl font-bold text-green-900">Plants</h3>
        <div class="flex gap-4">
            <x-button-admin type="submit" name="view" value="View" />

            @can('inventory-access')

                <x-button-admin type="submit" name="update" value="Update" />
                <a href="{{ route('inventories.create') }}">
                    <x-button-admin type="submit" name="add" value="Add" />
                </a>            
                <x-button-admin type="submit" name="delete" value="Delete" />
                
            @endcan

        </div>
        
    </div>
    

    @php

        // Set the headings to be displayed
        $inventoryHeadings = [
            'Select',
            'Plant ID',
            'Type',
            "Tree",
            "Pot_Size",
            "Area",
            "Block",
            "Aisle",
            "Quantity",
            'Height Min',
            'Height Max',
            'Width Min',
            'Width Max',
        ];

        // Initialise an empty array for the rows
        $inventoryRows = [];

        // For each inventory in inventories
        foreach ($inventories as $inventory)
            {
                // Add the contents of the inventory variable to the table
                $inventoryRows[] = [
                    $inventory->id,
                    $inventory->tree->plant_id,
                    $inventory->tree->tree_type->name,
                    $inventory->tree->common_name,
                    $inventory->pot_size->size,
                    $inventory->location->area->name,
                    $inventory->location->block?->name ?? '',
                    $inventory->location->aisle?->name ?? '',
                    $inventory->quantity,
                    $inventory->tree->mature_height_min,
                    $inventory->tree->mature_height_max,
                    $inventory->tree->mature_width_min,
                    $inventory->tree->mature_width_max,
                ];
            }

        // Hide Columns on small screens
        $hideColumns = [1, 2, 5, 6, 7, 9, 10, 11, 12];

    @endphp

    <x-table-filter
        :headings="$inventoryHeadings" 
        :rows="$inventoryRows"
        :hideColumns="$hideColumns"
        :filterColumns="[1, 2, 3, 4, 5, 6, 7, 9, 10, 11, 12]"
        :showTotals="true"
        :sumColumn="8"
        tbodyId="inventory_table_body"
        :paginate="true"
    />

    <!-- ========================= -->
    <!-- Import Scripts -->
    <!-- ========================= -->
    @push('scripts')
        <script>

            const inventoriesEditRoute = "{{ route('inventories.edit', ':id') }}";
            const inventorieShowRoute = "{{ route('inventories.show', ':id') }}";
            const inventoriesDeleteRoute = "{{ route('inventories.delete_confirm', ':id') }}";

        </script>
        <script src="{{ asset('js/table_helpers.js') }}"></script>
        <script src="{{ asset('js/menu_top/inventories/inventories.js') }}"></script>

    @endpush

@endsection
