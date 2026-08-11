
@extends('layouts.app')

@section('title')
    Pots
@endsection

@section('content')
    <h2 class="text-3xl font-bold text-green-900">Welcome to the Pots reference data, {{ $name }}</h2>

    <!-- Back to Admin Menu Button  -->
    <x-back-admin />

    <!-- Page text  -->
    <p class="mt-4 text-stone-700">
        Below are the current Pot sizes. This list is hard-coded for now and will later be replaced with database data.
    </p>

    <!-- ========================= -->
    <!-- Pot Sizes (Basic Table) -->
    <!-- ========================= -->
    

    <!-- Label and Buttons -->
    <div class="flex justify-between items-center mt-10">
        <h3 class="text-2xl font-bold text-green-900">Pot Sizes</h3>
        <div class="flex gap-4">
            <x-button-admin type="submit" name="update" value="Update" />
            <x-button-admin type="submit" name="add" value="Add" />
            <x-button-admin type="submit" name="delete" value="Delete" />
        </div>
        
    </div>

    @php
        $potSizeHeadings = ['Size'];

        $potSizeRows = [
            ["300 mm"],
            ["25 lt"],
            ["45 lt"],
            ["100 lt"],
            ["150 lt"],
        ];

        // Hide No Columns
        $hideColumns = [];

    @endphp

    <x-table-basic 
        :headings="$potSizeHeadings" 
        :rows="$potSizeRows"
    />
    
@endsection
