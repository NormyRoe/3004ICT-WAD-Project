
@extends('layouts.app')

@section('title')
    Trees
@endsection

@section('content')
    <h2 class="text-3xl font-bold text-green-900">Welcome to the Trees reference data, {{ auth()->user()->first_name }}</h2>

    <!-- Back to Admin Menu Button  -->
    <x-back-admin />

    <!-- Page text  -->
    <p class="mt-4 text-stone-700">
        Below are the current Tree Types and Tree details.
    </p>

    <!-- Update Success Message  -->
    @if(session('success'))
        <div class="bg-amber-200 text-orange-900 p-4 rounded mb-4 mt-4 border border-amber-600 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- ========================= -->
    <!-- Tree Types (Basic Table with Total) -->
    <!-- ========================= -->
    

    <!-- Label and Buttons -->
    <div class="flex justify-between items-center mt-10">
        <h3 class="text-2xl font-bold text-green-900">Tree Types</h3>
        <div class="flex gap-4">
            <x-button-admin type="submit" name="update_type" value="Update" />
            <x-button-admin type="submit" name="add_type" value="Add" />
            <x-button-admin type="submit" name="delete_type" value="Delete" />
        </div>
        
    </div>

    @php

        // Set the headings to be displayed
        $treeTypeHeadings = ['Select', 'Type'];

        // Initialise an empty array for the rows
        $treeTypeRows = [];

        // For each type in tree_types
        foreach ($tree_types as $type)
            {
                // Add the contents of the name variable to the table
                $treeTypeRows[] = [
                    $type->id, 
                    $type->name
                ];
            }

        // Hide No Columns
        $hideColumns = [];

    @endphp

    <x-table-basic
        :headings="$treeTypeHeadings" 
        :rows="$treeTypeRows"
        :sumColumn=null
        tbodyId="tree_type_table_body"
        :paginate="true"
    />
    

    <!-- ========================= -->
    <!-- Trees (Filtering Table with Total) -->
    <!-- ========================= -->

    <!-- Label and Buttons -->
    <div class="flex justify-between items-center mt-10">
        <h3 class="text-2xl font-bold text-green-900">Trees</h3>
        <div class="flex gap-4">
            <x-button-admin type="submit" name="view_tree" value="View" />
            <x-button-admin type="submit" name="update_tree" value="Update" />
            <x-button-admin type="submit" name="add_tree" value="Add" />
            <x-button-admin type="submit" name="delete_tree" value="Delete" />
        </div>
        
    </div>
    

    @php

        // Set the headings to be displayed
        $treeHeadings = [
            'Select',
            "Plant I.D.",
            "Type",
            "Botanical Name",
            "Common Name",
            "Mature Height Min",
            "Mature Height Max",
            "Mature Width Min",
            "Mature Width Max"
        ];

        // Initialise an empty array for the rows
        $treeRows = [];

        // For each tree in trees
        foreach ($trees as $tree)
            {
                // Add the contents of the name variable to the table
                $treeRows[] = [
                    $tree->id, 
                    $tree->plant_id,
                    $tree->tree_type->name,
                    $tree->botanical_name,
                    $tree->common_name,
                    $tree->mature_height_min,
                    $tree->mature_height_max,
                    $tree->mature_width_min,
                    $tree->mature_width_max,
                ];
            }

        // Hide Botanical Name, Height and Width on small screens
        $hideColumns = [3, 5, 6, 7, 8];

    @endphp

    <x-table-filter
        :headings="$treeHeadings" 
        :rows="$treeRows"
        :hideColumns="$hideColumns"
        :filterColumns="[2, 5, 6, 7, 8]"
        :showTotals="true"
        :sumColumn=null
        tbodyId="tree_table_body"
        :paginate="true"
    />

    <!-- ========================= -->
    <!-- Import Scripts -->
    <!-- ========================= -->
    @push('scripts')
        <script>

            const treeTypesEditRoute = "{{ route('tree_types.edit', ':id') }}";
            const treeTypesDeleteRoute = "{{ route('tree_types.delete_confirm', ':id') }}";

            const treesEditRoute = "{{ route('trees.edit', ':id') }}";
            const treesDeleteRoute = "{{ route('trees.delete_confirm', ':id') }}";
            const treesShowRoute = "{{ route('trees.show', ':id') }}";

        </script>
        <script src="{{ asset('js/table_helpers.js') }}"></script>
        <script src="{{ asset('js/admin/trees.js') }}"></script>
    @endpush

@endsection

