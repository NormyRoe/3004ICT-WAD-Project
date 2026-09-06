
@extends('layouts.app')

@section('title')
    Tree Locations
@endsection

@section('content')
    <h2 class="text-3xl font-bold text-green-900">Welcome to the Tree Locations reference data, {{ auth()->user()->first_name }}</h2>

    <!-- Back to Admin Menu Button  -->
    <x-back-admin />

    <!-- Page text  -->
    <p class="mt-4 text-stone-700">
        Below are the current Areas, Blocks, Aisle and Locations.
    </p>

    <!-- ========================= -->
    <!-- Areas (Basic Table with Total) -->
    <!-- ========================= -->
    

    <!-- Label and Buttons -->
    <div class="flex justify-between items-center mt-10">
        <h3 class="text-2xl font-bold text-green-900">Areas</h3>
        <div class="flex gap-4">
            <x-button-admin type="submit" name="update_area" value="Update" />
            <x-button-admin type="submit" name="add_area" value="Add" />
            <x-button-admin type="submit" name="delete_area" value="Delete" />
        </div>
        
    </div>

    @php

        // Set the headings to be displayed
        $areaHeadings = ['Select', 'Area'];

        // Initialise an empty array for the rows
        $areaRows = [];

        // For each type in areas
        foreach ($areas as $area)
        {
            // Add the contents to the table
            $areaRows[] = [
                $area->id, 
                $area->name
            ];
        }

        // Hide No Columns
        $hideColumns = [];

    @endphp

    <x-table-basic
        :headings="$areaHeadings" 
        :rows="$areaRows"
        :sumColumn=null
        tbodyId="area_table_body"
        :paginate="false"
    />

    <!-- ========================= -->
    <!-- Blocks (Basic Table with Total) -->
    <!-- ========================= -->
    

    <!-- Label and Buttons -->
    <div class="flex justify-between items-center mt-10">
        <h3 class="text-2xl font-bold text-green-900">Blocks</h3>
        <div class="flex gap-4">
            <x-button-admin type="submit" name="update_block" value="Update" />
            <x-button-admin type="submit" name="add_block" value="Add" />
            <x-button-admin type="submit" name="delete_block" value="Delete" />
        </div>
        
    </div>

    @php

        // Set the headings to be displayed
        $blockHeadings = ['Select', 'Block'];

        // Initialise an empty array for the rows
        $blockRows = [];

        // For each type in blocks
        foreach ($blocks as $block)
        {
            // Add the contents to the table
            $blockRows[] = [
                $block->id, 
                $block->name
            ];
        }

        // Hide No Columns
        $hideColumns = [];

    @endphp

    <x-table-basic-total 
        :headings="$blockHeadings" 
        :rows="$blockRows"
        :sumColumn=null
        tbodyId="block_table_body"
        :paginate="true"
    />

    <!-- ========================= -->
    <!-- Aisles (Basic Table with Total) -->
    <!-- ========================= -->
    

    <!-- Label and Buttons -->
    <div class="flex justify-between items-center mt-10">
        <h3 class="text-2xl font-bold text-green-900">Aisles</h3>
        <div class="flex gap-4">
            <x-button-admin type="submit" name="update_aisle" value="Update" />
            <x-button-admin type="submit" name="add_aisle" value="Add" />
            <x-button-admin type="submit" name="delete_aisle" value="Delete" />
        </div>
        
    </div>

    @php

        // Set the headings to be displayed
        $aisleHeadings = ['Select', 'Aisle'];

        // Initialise an empty array for the rows
        $aisleRows = [];

        // For each type in aisles
        foreach ($aisles as $aisle)
        {
            // Add the contents to the table
            $aisleRows[] = [
                $aisle->id, 
                $aisle->name
            ];
        }

        // Hide No Columns
        $hideColumns = [];

    @endphp

    <x-table-basic 
        :headings="$aisleHeadings" 
        :rows="$aisleRows"
        :sumColumn=null
        tbodyId="aisle_table_body"
        :paginate="false"
    />

    <!-- ========================= -->
    <!-- Locations (Filtering Table with Total) -->
    <!-- ========================= -->

    <!-- Label and Buttons -->
    <div class="flex justify-between items-center mt-10">
        <h3 class="text-2xl font-bold text-green-900">Locations</h3>
        <div class="flex gap-4">
            <x-button-admin type="submit" name="update_location" value="Update" />
            <x-button-admin type="submit" name="add_location" value="Add" />
            <x-button-admin type="submit" name="delete_location" value="Delete" />
        </div>
        
    </div>
    

    @php

        // Set the headings to be displayed
        $locationHeadings = [
            "Select",
            "Area",
            "Block",
            "Aisle",
        ];

        // Initialise an empty array for the rows
        $locationRows = [];

        // For each type in location
        foreach ($locations as $location)
        {
            // Add the contents to the table
            $locationRows[] = [
                $location->id, 
                $location->area->name,
                $location->block?->name ?? '',
                $location->aisle?->name ?? '',
            ];
        }

        // Hide Columns on small screens
        $hideColumns = [];

    @endphp

    <x-table-filter
        :headings="$locationHeadings" 
        :rows="$locationRows"
        :hideColumns="$hideColumns"
        :filterColumns="[1, 2, 3]"
        :showTotals="true"
        :sumColumn=null
        tbodyId="location_table_body"
        :paginate="true"
    />
    
    <!-- ========================= -->
    <!-- Import Scripts -->
    <!-- ========================= -->
    @push('scripts')

        <script>

            const areasEditRoute = "{{ route('areas.edit', ':id') }}";
            const areasDeleteRoute = "{{ route('areas.delete_confirm', ':id') }}";

            const blocksEditRoute = "{{ route('blocks.edit', ':id') }}";
            const blocksDeleteRoute = "{{ route('blocks.delete_confirm', ':id') }}";

            const aislesEditRoute = "{{ route('aisles.edit', ':id') }}";
            const aislesDeleteRoute = "{{ route('aisles.delete_confirm', ':id') }}";

            const locationsEditRoute = "{{ route('locations.edit', ':id') }}";
            const locationsDeleteRoute = "{{ route('locations.delete_confirm', ':id') }}";

        </script>
        <script src="{{ asset('js/table_helpers.js') }}"></script>
        <script src="{{ asset('js/admin/locations.js') }}"></script>

    @endpush

@endsection
