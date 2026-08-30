
@extends('layouts.app')

@section('title')
    Tasks
@endsection

@section('content')
    <h2 class="text-3xl font-bold text-green-900">Welcome to the Tasks area, {{ $name }}</h2>

    <!-- Page text  -->
    <p class="mt-4 text-stone-700">
        Here are all of your currently allocated tasks.  If you are a manager, than this page also shows all unallocated and 
        all currently allocated tasks.
    </p>

    <!-- ========================= -->
    <!-- Current User Tasks (Filtering Table with Total) -->
    <!-- ========================= -->

    <!-- Label and Buttons -->
    <div class="flex justify-between items-center mt-10">
        <h3 class="text-2xl font-bold text-green-900">{{ $name }}'s Current Tasks</h3>
        <div class="flex gap-4">
            <x-button-admin type="submit" name="done" value="Done" />
            <x-button-admin type="submit" name="add" value="Add" />
        </div>
        
    </div>
    

    @php
        $currentUserTasksHeadings = [
            "Date",
            "Task",
            "Tree",
            "Location_1",
            "Location_2",
            "Quantity",
            "Notes",
        ];

        $currentUserTasksRows = [
            ["11/07/2026","Move", "Northern form Lilly Pilly","Block A Aisle 1","Block D Aisle 4","200",""],
            ["12/07/2026","Weed", "","Block C","","","Weed all of the trees in the block"],
        ];

        // Hide Columns on small screens
        $hideColumns = [];

    @endphp

    <x-table-filter
        :headings="$currentUserTasksHeadings" 
        :rows="$currentUserTasksRows"
        :hideColumns="$hideColumns"
        :filterColumns="[0]"
        :showTotals="true"
        :sumColumn=null
    />


    <!-- ========================= -->
    <!-- Unallocated Tasks (Filtering Table with Total) -->
    <!-- ========================= -->

    <!-- Label and Buttons -->
    <div class="flex justify-between items-center mt-10">
        <h3 class="text-2xl font-bold text-green-900">Unallocated Tasks</h3>
        <div class="flex gap-4">
            <x-button-admin type="submit" name="update" value="Update" />
            <x-button-admin type="submit" name="add" value="Add" />
        </div>
        
    </div>
    

    @php
        $unallocatedTasksHeadings = [
            "Date",
            "Task",
            "Tree",
            "Location_1",
            "Location_2",
            "Quantity",
            "Notes",
        ];

        $unallocatedTasksRows = [
            ["11/07/2026","Move", "Northern form Lilly Pilly","Block A Aisle 1","Block D Aisle 4","200",""],
            ["12/07/2026","Weed", "","Block C","","","Weed all of the trees in the block"],
        ];

        // Hide Columns on small screens
        $hideColumns = [];

    @endphp

    <x-table-filter
        :headings="$unallocatedTasksHeadings" 
        :rows="$unallocatedTasksRows"
        :hideColumns="$hideColumns"
        :filterColumns="[0]"
        :showTotals="true"
        :sumColumn=null
    />


    <!-- ========================= -->
    <!-- All User Tasks (Filtering Table with Total) -->
    <!-- ========================= -->

    <!-- Label and Buttons -->
    <div class="flex justify-between items-center mt-10">
        <h3 class="text-2xl font-bold text-green-900">All Current Tasks</h3>
        <div class="flex gap-4">
            <x-button-admin type="submit" name="update" value="Update" />
            <x-button-admin type="submit" name="add" value="Add" />
        </div>
        
    </div>
    

    @php
        $allUserTasksHeadings = [
            "Date",
            "Task",
            "Tree",
            "Location_1",
            "Location_2",
            "Quantity",
            "Notes",
            "User",
        ];

        $allUserTasksRows = [
            ["11/07/2026","Move", "Northern form Lilly Pilly","Block A Aisle 1","Block D Aisle 4","200","","Bob"],
            ["11/07/2026","Prune", "Compact Lilly Pilly","Block B Aisle 2","","100","","Lucy"],
            ["12/07/2026","Weed", "","Block C","","","Weed all of the trees in the block","Bob"],
            ["12/07/2026","Destory", "Compact Lilly Pilly","Block C Aisle 3","","10","","Lucy"],
            ["13/07/2026","Report", "","Block H Aisle 4","","","The plants have a bug eating the leaves","admin"],
        ];

        // Hide Columns on small screens
        $hideColumns = [];

    @endphp

    <x-table-filter
        :headings="$allUserTasksHeadings" 
        :rows="$allUserTasksRows"
        :hideColumns="$hideColumns"
        :filterColumns="[0, 7]"
        :showTotals="true"
        :sumColumn=null
    />

@endsection
