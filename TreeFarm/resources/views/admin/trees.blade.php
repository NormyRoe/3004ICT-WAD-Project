
@extends('layouts.app')

@section('title')
    Trees
@endsection

@section('content')
    <h2 class="text-3xl font-bold text-green-900">Welcome to the Trees reference data, {{ $name }}</h2>

    <!-- Back to Admin Menu Button  -->
    <x-back-admin />

    <!-- Page text  -->
    <p class="mt-4 text-stone-700">
        Below are the current Tree Types and Tree details. These lists are hard-coded for now and will later be replaced with database data.
    </p>

    <!-- ========================= -->
    <!-- Tree Types (Basic Table with Total) -->
    <!-- ========================= -->
    

    <!-- Label and Buttons -->
    <div class="flex justify-between items-center mt-10">
        <h3 class="text-2xl font-bold text-green-900">Tree Types</h3>
        <div class="flex gap-4">
            <x-button-admin type="submit" name="update" value="Update" />
            <x-button-admin type="submit" name="add" value="Add" />
            <x-button-admin type="submit" name="delete" value="Delete" />
        </div>
        
    </div>

    @php
        $treeTypeHeadings = ['Type'];

        $treeTypeRows = [
            ["Lilly Pilly"],
            ["Other Natives"],
            ["Exotics"],
            ["Palms"],
        ];

        // Hide No Columns
        $hideColumns = [];

    @endphp

    <x-table-basic-total 
        :headings="$treeTypeHeadings" 
        :rows="$treeTypeRows"
        :sumColumn=null
    />
    

    <!-- ========================= -->
    <!-- Trees (Filtering Table with Total) -->
    <!-- ========================= -->

    <!-- Label and Buttons -->
    <div class="flex justify-between items-center mt-10">
        <h3 class="text-2xl font-bold text-green-900">Trees</h3>
        <div class="flex gap-4">
            <x-button-admin type="submit" name="update" value="Update" />
            <x-button-admin type="submit" name="add" value="Add" />
            <x-button-admin type="submit" name="delete" value="Delete" />
        </div>
        
    </div>
    

    @php
        $treeHeadings = [
            "Plant I.D.",
            "Type",
            "Botanical Name",
            "Common Name",
            "Mature Height Min",
            "Mature Height Max",
            "Mature Width Min",
            "Mature Width Max"
        ];

        $treeRows = [
            ["2B","Lilly Pilly","Syzygium australe Baby Boomer","Baby Boomer Lilly Pilly","","1.5","","1.5"],
            ["3","Lilly Pilly","Syzygium australe Captain Cook","Captain Cook Lilly Pilly","","6","","4"],
            ["5","Lilly Pilly","Syzygium a. Aussie Northern","Northern form Lilly Pilly","","5","","2"],
            ["6","Lilly Pilly","Syzygium a. Aussie Southern","Glossy Lilly Pilly","","5","","2"],
            ["7","Lilly Pilly","Syzygium a. Wilsonii","Powder Puff Lilly Pilly","","5","","2"],
            ["8","Lilly Pilly","Syzygium a. Elegance PBR","Compact Lilly Pilly","","3","","2"],
            ["9","Lilly Pilly","Syzygium a. Elite","Dwarf Magenta Cherry (green)","","3","","1.5"],
            ["10","Lilly Pilly","Syzygium a. Elite Red","Dwarf Magenta Cherry (red)","","3","","1.5"],
            ["11","Lilly Pilly","Syzygium a. Express","Lilly Pilly Express","","4","","1.5"],
            ["12","Lilly Pilly","Syzygium a. Hinterland Gold","Gold Lilly Pilly","","4","","1.5"],
            ["13","Lilly Pilly","Syzygium Cascade PBR","Cascade Lilly Pilly","","4","","3"],
            ["14","Lilly Pilly","Syzygium (Waterhousea) Floribundum","Weeping Lilly Pilly","","10","","5"],
            ["15","Lilly Pilly","Syzygium Francisii","Francis's Water Gum","8","15","","6"],
            ["16","Lilly Pilly","Syzygium (Acmena) Hemilamprum","Blush Satinash Hinterland","","8","","4"],
            ["17","Lilly Pilly","Syzygium australe Straight & Narrow","Straight and Narrow Lilly Pilly","","8","","1.5"],
        ];

        // Hide Botanical Name and Common Name on small screens
        $hideColumns = [2, 3];
    @endphp

    <x-table-filter-total 
        :headings="$treeHeadings" 
        :rows="$treeRows"
        :hideColumns="$hideColumns"
        :filterColumns="[1, 4, 5, 6, 7]"
        :sumColumn=null
    />

@endsection

