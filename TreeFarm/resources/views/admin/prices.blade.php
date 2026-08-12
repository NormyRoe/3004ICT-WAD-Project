
@extends('layouts.app')

@section('title')
    Prices
@endsection

@section('content')
    <h2 class="text-3xl font-bold text-green-900">Welcome to the Prices reference data, {{ $name }}</h2>

    <!-- Back to Admin Menu Button  -->
    <x-back-admin />

    <!-- Page text  -->
    <p class="mt-4 text-stone-700">
        Below are the Prices and Exception Prices. This list is hard-coded for now and will later be replaced with database data.
    </p>

    <!-- ========================= -->
    <!-- Prices (Basic Table) -->
    <!-- ========================= -->
    

    <!-- Label and Buttons -->
    <div class="flex justify-between items-center mt-10">
        <h3 class="text-2xl font-bold text-green-900">Prices</h3>
        <div class="flex gap-4">
            <x-button-admin type="submit" name="update" value="Update" />
            <x-button-admin type="submit" name="add" value="Add" />
            <x-button-admin type="submit" name="delete" value="Delete" />
        </div>
        
    </div>

    @php
        $pricesHeadings = [
            "Name",
            "Size",
            "Price ($)",
            "Rate (%)",
        ];

        $pricesRows = [
            ["Pot Size Price","300 mm","",""],
            ["Pot Size Price","25 lt","55",""],
            ["Pot Size Price","45 lt","115",""],
            ["Pot Size Price","100 lt","275",""],
            ["Pot Size Price","150 lt","395",""],
            ["Delivery Rate","","2.5",""],
            ["Delivery Minimum","","110",""],
            ["GST","","","10"],
        ];

        // Hide No Columns
        $hideColumns = [];

    @endphp

    <x-table-basic 
        :headings="$pricesHeadings" 
        :rows="$pricesRows"
    />

    <!-- ========================= -->
    <!-- Exception Prices (Filtering Table with Total ) -->
    <!-- ========================= -->
    

    <!-- Label and Buttons -->
    <div class="flex justify-between items-center mt-10">
        <h3 class="text-2xl font-bold text-green-900">Exception Prices</h3>
        <div class="flex gap-4">
            <x-button-admin type="submit" name="update" value="Update" />
            <x-button-admin type="submit" name="add" value="Add" />
            <x-button-admin type="submit" name="delete" value="Delete" />
        </div>
        
    </div>

    @php
        $exceptionsHeadings = [
            "Tree",
            "Pot Size",
            "Price ($)",
        ];

        $exceptionsRows = [
            ["Lemon Scented Myrtle","25 lt","99"],
            ["Lemon Scented Myrtle","45 lt","187"],
            ["Lemon Scented Myrtle","100 lt","385"],
            ["Lemon Scented Myrtle","150 lt","495"],
            ["Eumundi Quondong","25 lt","99"],
            ["Eumundi Quondong","45 lt","187"],
            ["Eumundi Quondong","100 lt","385"],
            ["Eumundi Quondong","150 lt","495"],
            ["Magnolia grandiflora Teddy Bear","25 lt","99"],
            ["Magnolia grandiflora Teddy Bear","45 lt","187"],
            ["Magnolia grandiflora Teddy Bear","100 lt","385"],
            ["Magnolia grandiflora Teddy Bear","150 lt","495"],
            ["Water Gum","25 lt","99"],
            ["Water Gum","45 lt","187"],
            ["Water Gum","100 lt","385"],
            ["Water Gum","150 lt","495"],
        ];

        // Hide No Columns
        $hideColumns = [];

    @endphp

    <x-table-filter-total 
        :headings="$exceptionsHeadings" 
        :rows="$exceptionsRows"
        :hideColumns="$hideColumns"
        :filterColumns="[0, 1, 2]"
        :sumColumn=null
    />
    
@endsection
