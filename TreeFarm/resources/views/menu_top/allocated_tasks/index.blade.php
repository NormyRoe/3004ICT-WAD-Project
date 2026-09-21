
@extends('layouts.app')

@section('title')
    Tasks
@endsection

@section('content')
    <h2 class="text-3xl font-bold text-green-900">Welcome to the Tasks area, {{ auth()->user()->first_name }}</h2>

    <!-- Page text  -->
    <p class="mt-4 text-stone-700">
        Here are all of your currently allocated tasks.  If you are a manager, then this page also shows all unallocated, 
        currently allocated and completed tasks.
    </p>

    <!-- Update Success Message  -->
    @if(session('success'))
        <div class="bg-amber-200 text-orange-900 p-4 rounded mb-4 mt-4 border border-amber-600 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- ========================= -->
    <!-- Current User Tasks (Filtering Table with Total) -->
    <!-- ========================= -->

    <!-- Label and Buttons -->
    <div class="flex justify-between items-center mt-10">
        <h3 class="text-2xl font-bold text-green-900">{{ auth()->user()->first_name }}'s Current Tasks</h3>
        <div class="flex gap-4">
            <x-button-admin type="submit" name="view_current" value="View" />
            <x-button-admin type="submit" name="update_current" value="Update" />
            <a href="{{ route('allocated_tasks.create_report') }}">
                <x-button-admin type="button" value="Report" />
            </a>
        </div>
        
    </div>
    

    @php

        // Set the headings to be displayed
        $currentUserTaskHeadings = [
            'Select',
            "Date",
            "Task",
            "Tree",            
            "Existing Location",
            "New Location",
            "Quantity",
            "Pot Size",
            "Notes",
        ];

        // Initialise an empty array for the rows
        $currentUserTaskRows = [];

        // For each task in current_user_tasks
        foreach ($current_user_tasks as $task)
            {
                // Build location_1 string
                $location_1 = '';

                if ($task->location_1) {
                    $location_1 = $task->location_1->area->name;

                    if ($task->location_1->block) {
                        $location_1 .= ' : Block ' . $task->location_1->block->name;
                    }

                    if ($task->location_1->aisle) {
                        $location_1 .= ' : Aisle ' . $task->location_1->aisle->name;
                    }
                }

                // Build location_2 string
                $location_2 = '';

                if ($task->location_2) {
                    $location_2 = $task->location_2->area->name;

                    if ($task->location_2->block) {
                        $location_2 .= ' : Block ' . $task->location_2->block->name;
                    }

                    if ($task->location_2->aisle) {
                        $location_2 .= ' : Aisle ' . $task->location_2->aisle->name;
                    }
                }

                // Add the contents of the task variable to the table
                $currentUserTaskRows[] = [
                    $task->id,
                    $task->date->format('d/m/Y'),
                    $task->task->name,
                    $task->tree?->common_name ?? '',
                    $location_1,
                    $location_2,
                    $task->quantity ?? '',
                    $task->pot_size?->size ?? '',
                    $task->notes ?? '',
                ];
            }

        // Hide Columns on small screens
        $hideColumns = [4, 5, 6, 7, 8];

    @endphp

    <x-table-filter
        :headings="$currentUserTaskHeadings" 
        :rows="$currentUserTaskRows"
        :hideColumns="$hideColumns"
        :filterColumns="[1, 2]"
        :showTotals="true"
        :sumColumn=null
        tbodyId="current_tasks_table_body"
        :paginate="true"
        filterPrefix="current_"
    />


    @can('admin-access')

        <!-- ========================= -->
        <!-- Unallocated Tasks (Filtering Table with Total) -->
        <!-- ========================= -->

        <!-- Label and Buttons -->
        <div class="flex justify-between items-center mt-10">
            <h3 class="text-2xl font-bold text-green-900">Unallocated Tasks</h3>
            <div class="flex gap-4">
                <x-button-admin type="submit" name="view_unallocated" value="View" />
                <x-button-admin type="submit" name="update_unallocated" value="Update" />
                <a href="{{ route('allocated_tasks.create') }}">
                    <x-button-admin type="submit" name="add" value="Add" />
                </a>
                <x-button-admin type="submit" name="delete_unallocated" value="Delete" />
            </div>        
        </div>
        

        @php

            // Set the headings to be displayed
            $unallocatedTaskHeadings = [
                'Select',
                "Date",
                "Task",
                "Tree",
                "Existing Location",
                "New Location",
                "Quantity",
                "Pot Size",
                "Notes",
            ];

            // Initialise an empty array for the rows
            $unallocatedTaskRows = [];

            // For each task in unallocated_tasks
            foreach ($unallocated_tasks as $task)
                {
                    // Build location_1 string
                    $location_1 = '';

                    if ($task->location_1) {
                        $location_1 = $task->location_1->area->name;

                        if ($task->location_1->block) {
                            $location_1 .= ' : Block ' . $task->location_1->block->name;
                        }

                        if ($task->location_1->aisle) {
                            $location_1 .= ' : Aisle ' . $task->location_1->aisle->name;
                        }
                    }

                    // Build location_2 string
                    $location_2 = '';

                    if ($task->location_2) {
                        $location_2 = $task->location_2->area->name;

                        if ($task->location_2->block) {
                            $location_2 .= ' : Block ' . $task->location_2->block->name;
                        }

                        if ($task->location_2->aisle) {
                            $location_2 .= ' : Aisle ' . $task->location_2->aisle->name;
                        }
                    }

                    // Add the contents of the task variable to the table
                    $unallocatedTaskRows[] = [
                        $task->id,
                        $task->date->format('d/m/Y'),
                        $task->task->name,
                        $task->tree?->common_name ?? '',
                        $location_1,
                        $location_2,
                        $task->quantity ?? '',
                        $task->pot_size?->size ?? '',
                        $task->notes ?? '',
                    ];
                }

            // Hide Columns on small screens
            $hideColumns = [4, 5, 6, 7, 8];

        @endphp

        <x-table-filter
            :headings="$unallocatedTaskHeadings" 
            :rows="$unallocatedTaskRows"
            :hideColumns="$hideColumns"
            :filterColumns="[1, 2]"
            :showTotals="true"
            :sumColumn=null
            tbodyId="unallocated_tasks_table_body"
            :paginate="true"
            filterPrefix="unallocated_"
        />


        <!-- ========================= -->
        <!-- All Current Allocated Tasks --> 
        <!-- (Filtering Table with Total) -->
        <!-- ========================= -->

        <!-- Label and Buttons -->
        <div class="flex justify-between items-center mt-10">
            <h3 class="text-2xl font-bold text-green-900">All Currently Allocated Tasks</h3>
            <div class="flex gap-4">
                <x-button-admin type="submit" name="view_allocated" value="View" />
                <x-button-admin type="submit" name="update_allocated" value="Update" />
                <a href="{{ route('allocated_tasks.create') }}">
                    <x-button-admin type="submit" name="add" value="Add" />
                </a>
                <x-button-admin type="submit" name="delete_allocated" value="Delete" />
            </div>
            
        </div>
        

        @php

            // Set the headings to be displayed
            $allAllocatedTaskHeadings = [
                'Select',
                "Date",
                "Task",
                "Tree",
                "Existing Location",
                "New Location",
                "Quantity",
                "Pot Size",
                "Notes",
                
            ];

            // Initialise an empty array for the rows
            $allAllocatedTaskRows = [];

            // For each task in allocated_tasks
            foreach ($allocated_tasks as $task)
                {
                    // Build location_1 string
                    $location_1 = '';

                    if ($task->location_1) {
                        $location_1 = $task->location_1->area->name;

                        if ($task->location_1->block) {
                            $location_1 .= ' : Block ' . $task->location_1->block->name;
                        }

                        if ($task->location_1->aisle) {
                            $location_1 .= ' : Aisle ' . $task->location_1->aisle->name;
                        }
                    }

                    // Build location_2 string
                    $location_2 = '';

                    if ($task->location_2) {
                        $location_2 = $task->location_2->area->name;

                        if ($task->location_2->block) {
                            $location_2 .= ' : Block ' . $task->location_2->block->name;
                        }

                        if ($task->location_2->aisle) {
                            $location_2 .= ' : Aisle ' . $task->location_2->aisle->name;
                        }
                    }

                    // Add the contents of the task variable to the table
                    $allAllocatedTaskRows[] = [
                        $task->id,
                        $task->date->format('d/m/Y'),
                        $task->task->name,
                        $task->tree?->common_name ?? '',
                        $location_1,
                        $location_2,
                        $task->quantity ?? '',
                        $task->pot_size?->size ?? '',
                        $task->notes ?? '',
                    ];
                }

            // Hide Columns on small screens
            $hideColumns = [4, 5, 6, 7, 8];

        @endphp

        <x-table-filter
            :headings="$allAllocatedTaskHeadings" 
            :rows="$allAllocatedTaskRows"
            :hideColumns="$hideColumns"
            :filterColumns="[1, 2]"
            :showTotals="true"
            :sumColumn=null
            tbodyId="allocated_tasks_table_body"
            :paginate="true"
            filterPrefix="allocated_"
        />
        
        <!-- ========================= -->
        <!-- All Completed Tasks --> 
        <!-- (Filtering Table with Total) -->
        <!-- ========================= -->

        <!-- Label and Buttons -->
        <div class="flex justify-between items-center mt-10">
            <h3 class="text-2xl font-bold text-green-900">All Completed Tasks</h3>
            <div class="flex gap-4">
                <x-button-admin type="submit" name="view_completed" value="View" />
            </div>
            
        </div>
        

        @php

            // Set the headings to be displayed
            $completedTaskHeadings = [
                'Select',
                "Date",
                "Task",
                "Tree",
                "Existing Location",
                "New Location",
                "Quantity",
                "Pot Size",
                "Notes",
                
            ];

            // Initialise an empty array for the rows
            $completedTaskRows = [];

            // For each task in completed_tasks
            foreach ($completed_tasks as $task)
                {
                    // Build location_1 string
                    $location_1 = '';

                    if ($task->location_1) {
                        $location_1 = $task->location_1->area->name;

                        if ($task->location_1->block) {
                            $location_1 .= ' : Block ' . $task->location_1->block->name;
                        }

                        if ($task->location_1->aisle) {
                            $location_1 .= ' : Aisle ' . $task->location_1->aisle->name;
                        }
                    }

                    // Build location_2 string
                    $location_2 = '';

                    if ($task->location_2) {
                        $location_2 = $task->location_2->area->name;

                        if ($task->location_2->block) {
                            $location_2 .= ' : Block ' . $task->location_2->block->name;
                        }

                        if ($task->location_2->aisle) {
                            $location_2 .= ' : Aisle ' . $task->location_2->aisle->name;
                        }
                    }

                    // Add the contents of the task variable to the table
                    $completedTaskRows[] = [
                        $task->id,
                        $task->date->format('d/m/Y'),
                        $task->task->name,
                        $task->tree?->common_name ?? '',
                        $location_1,
                        $location_2,
                        $task->quantity ?? '',
                        $task->pot_size?->size ?? '',
                        $task->notes ?? '',
                    ];
                }

            // Hide Columns on small screens
            $hideColumns = [4, 5, 6, 7, 8];

        @endphp

        <x-table-filter
            :headings="$completedTaskHeadings" 
            :rows="$completedTaskRows"
            :hideColumns="$hideColumns"
            :filterColumns="[1, 2]"
            :showTotals="true"
            :sumColumn=null
            tbodyId="completed_tasks_table_body"
            :paginate="true"
            filterPrefix="completed_"
        />

    @endcan

    <!-- ========================= -->
    <!-- Import Scripts -->
    <!-- ========================= -->
    @push('scripts')
        <script>

            const currentEditRoute = "{{ route('allocated_tasks.edit', ':id') }}";
            const currentShowRoute = "{{ route('allocated_tasks.show', ':id') }}";

            const unallocatedEditRoute = "{{ route('allocated_tasks.edit', ':id') }}";
            const unallocatedShowRoute = "{{ route('allocated_tasks.show', ':id') }}";
            const unallocatedDeleteRoute = "{{ route('allocated_tasks.delete_confirm', ':id') }}";

            const allocatedEditRoute = "{{ route('allocated_tasks.edit', ':id') }}";
            const allocatedShowRoute = "{{ route('allocated_tasks.show', ':id') }}";
            const allocatedDeleteRoute = "{{ route('allocated_tasks.delete_confirm', ':id') }}";

            const completedShowRoute = "{{ route('allocated_tasks.show', ':id') }}";

        </script>
        <script src="{{ asset('js/table_helpers.js') }}"></script>
        <script src="{{ asset('js/menu_top/allocated_tasks/tasks.js') }}"></script>

    @endpush

@endsection
