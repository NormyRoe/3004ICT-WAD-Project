
@extends('layouts.app')

@section('title')
    Task Types
@endsection

@section('content')
    <h2 class="text-3xl font-bold text-green-900">Welcome to the Task Types reference data, {{ $name }}</h2>

    <!-- Back to Admin Menu Button  -->
    <x-back-admin />

    <!-- Page text  -->
    <p class="mt-4 text-stone-700">
        Below are the current Task Types. This list is hard-coded for now and will later be replaced with database data.
    </p>

    <!-- ========================= -->
    <!-- Tasks (Basic Table) -->
    <!-- ========================= -->
    

    <!-- Label and Buttons -->
    <div class="flex justify-between items-center mt-10">
        <h3 class="text-2xl font-bold text-green-900">Task Types</h3>
        <div class="flex gap-4">
            <x-button-admin type="submit" name="update" value="Update" />
            <x-button-admin type="submit" name="add" value="Add" />
            <x-button-admin type="submit" name="delete" value="Delete" />
        </div>
        
    </div>

    @php
        $tasksHeadings = ['Task'];

        $tasksRows = [
            ["Move"],
            ["Prune"],
            ["Weed"],
            ["Destroy"],
            ["Tag"],
            ["Check irrigation"],
            ["Report"],
        ];

        // Hide No Columns
        $hideColumns = [];

    @endphp

    <x-table-basic 
        :headings="$tasksHeadings" 
        :rows="$tasksRows"
    />
    
@endsection
