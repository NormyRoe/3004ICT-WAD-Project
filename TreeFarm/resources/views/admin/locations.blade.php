
@extends('layouts.app')

@section('title')
    Tree Locations
@endsection

@section('content')
    <h2 class="text-3xl font-bold text-green-900">Welcome to the Tree Locations reference data, {{ $name }}</h2>

    <!-- Back to Admin Menu Button  -->
    <x-back-admin />

    <!-- Page text  -->
    <p class="mt-4 text-stone-700">
        Below are the current Areas, Blocks, Aisle and Locations. These lists are hard-coded for now and will later be replaced with database data.
    </p>

    <!-- ========================= -->
    <!-- Areas (Basic Table with Total) -->
    <!-- ========================= -->
    

    <!-- Label and Buttons -->
    <div class="flex justify-between items-center mt-10">
        <h3 class="text-2xl font-bold text-green-900">Areas</h3>
        <div class="flex gap-4">
            <x-button-admin type="submit" name="update" value="Update" />
            <x-button-admin type="submit" name="add" value="Add" />
            <x-button-admin type="submit" name="delete" value="Delete" />
        </div>
        
    </div>

    @php
        $areaHeadings = ['Area'];

        $areaRows = [
            ["Seedling"],
            ["Growing"],
            ["Selling"],
            ["Potting 1"],
            ["Potting 2"],
            ["Delivery"],
            ["Disposal"],
        ];

        // Hide No Columns
        $hideColumns = [];

    @endphp

    <x-table-basic-total 
        :headings="$areaHeadings" 
        :rows="$areaRows"
        :sumColumn=null
    />

    <!-- ========================= -->
    <!-- Blocks (Basic Table with Total) -->
    <!-- ========================= -->
    

    <!-- Label and Buttons -->
    <div class="flex justify-between items-center mt-10">
        <h3 class="text-2xl font-bold text-green-900">Blocks</h3>
        <div class="flex gap-4">
            <x-button-admin type="submit" name="update" value="Update" />
            <x-button-admin type="submit" name="add" value="Add" />
            <x-button-admin type="submit" name="delete" value="Delete" />
        </div>
        
    </div>

    @php
        $blockHeadings = ['Block'];

        $blockRows = [
            ["A"],
            ["B"],
            ["C"],
            ["D"],
            ["E"],
            ["F"],
            ["G"],
            ["H"],
            ["I"],
            ["J"],
            ["K"],
            ["L"],
        ];

        // Hide No Columns
        $hideColumns = [];

    @endphp

    <x-table-basic-total 
        :headings="$blockHeadings" 
        :rows="$blockRows"
        :sumColumn=null
    />

    <!-- ========================= -->
    <!-- Aisles (Basic Table with Total) -->
    <!-- ========================= -->
    

    <!-- Label and Buttons -->
    <div class="flex justify-between items-center mt-10">
        <h3 class="text-2xl font-bold text-green-900">Aisles</h3>
        <div class="flex gap-4">
            <x-button-admin type="submit" name="update" value="Update" />
            <x-button-admin type="submit" name="add" value="Add" />
            <x-button-admin type="submit" name="delete" value="Delete" />
        </div>
        
    </div>

    @php
        $aisleHeadings = ['Aisle'];

        $aisleRows = [
            ["1"],
            ["2"],
            ["3"],
            ["4"],
            ["5"],
        ];

        // Hide No Columns
        $hideColumns = [];

    @endphp

    <x-table-basic-total 
        :headings="$aisleHeadings" 
        :rows="$aisleRows"
        :sumColumn=null
    />

    <!-- ========================= -->
    <!-- Locations (Filtering Table with Total) -->
    <!-- ========================= -->

    <!-- Label and Buttons -->
    <div class="flex justify-between items-center mt-10">
        <h3 class="text-2xl font-bold text-green-900">Locations</h3>
        <div class="flex gap-4">
            <x-button-admin type="submit" name="update" value="Update" />
            <x-button-admin type="submit" name="add" value="Add" />
            <x-button-admin type="submit" name="delete" value="Delete" />
        </div>
        
    </div>
    

    @php
        $locationHeadings = [
            "Area",
            "Block",
            "Aisle",
        ];

        $locationRows = [
            ["Seedling","",""],
            ["Potting 1","",""],
            ["Potting 2","",""],
            ["Delivery","",""],
            ["Disposal","",""],
            ["Growing","A","1"],
            ["Growing","A","2"],
            ["Growing","A","3"],
            ["Growing","A","4"],
            ["Growing","A","5"],
            ["Growing","B","1"],
            ["Growing","B","2"],
            ["Growing","B","3"],
            ["Growing","B","4"],
            ["Growing","B","5"],
            ["Growing","C","1"],
            ["Growing","C","2"],
            ["Growing","C","3"],
            ["Growing","C","4"],
            ["Growing","C","5"],
        ];

        // Hide Columns on small screens
        $hideColumns = [];

    @endphp

    <x-table-filter-total 
        :headings="$locationHeadings" 
        :rows="$locationRows"
        :hideColumns="$hideColumns"
        :filterColumns="[0, 1, 2]"
        :sumColumn=null
    />
    
@endsection
