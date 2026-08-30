
@extends('layouts.app')

@section('title')
    Inventory
@endsection

@section('content')

    <h2 class="text-3xl font-bold text-green-900">Welcome to the Inventory area, {{ $name }}</h2>

    <!-- Page text  -->
    <p class="mt-4 text-stone-700">
        Here is all of the current inventory:
    </p>

    <!-- ========================= -->
    <!-- Inventory (Filtering Table with Total) -->
    <!-- ========================= -->

    <!-- Label and Buttons -->
    <div class="flex justify-between items-center mt-10">
        <h3 class="text-2xl font-bold text-green-900">Plants</h3>
        <div class="flex gap-4">
            <x-button-admin type="submit" name="update" value="Update" />
            <x-button-admin type="submit" name="add" value="Add" />
            <x-button-admin type="submit" name="delete" value="Delete" />
        </div>
        
    </div>
    

    @php
        $inventoryHeadings = [
            "Tree",
            "Pot_Size",
            "Area",
            "Block",
            "Aisle",
            "Quantity",
        ];

        $inventoryRows = [
            ["Northern form Lilly Pilly","25 lt", "Seedling","","","300"],
            ["Compact Lilly Pilly","25 lt", "Growing","A","1","300"],
            ["Weeping Lilly Pilly","45 lt", "Growing","B","3","500"],
            ["Compact Lilly Pilly","45 lt", "Growing","A","2","500"],
            ["Blush Satinash Hinterland","150 lt", "Selling","K","2","200"],
        ];

        // Hide Columns on small screens
        $hideColumns = [];

    @endphp

    <x-table-filter
        :headings="$inventoryHeadings" 
        :rows="$inventoryRows"
        :hideColumns="$hideColumns"
        :filterColumns="[0, 1, 2, 3, 4]"
        :showTotals="true"
        :sumColumn="6"
    />

@endsection
